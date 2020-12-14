<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Hshn\Base64EncodedFile\HttpFoundation\File\Base64EncodedFile;

class TransformBase64Inputs
{
    /** @var FileBag */
    protected $files;
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->transformsRequest($request);

        return $next($request);
    }

    /**
     * Transform the request's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function transformsRequest($request)
    {
        $this->files = new FileBag();

        $this->tranformRequest($request->query);

        if ($request->isJson()) {
            $this->tranformRequest($request->json());
        } else {
            $this->tranformRequest($request->request);
        }

        $this->replaceFiles($request->files);
    }

    /**
     * Transform the data in the parameter bag.
     *
     * @param  \Symfony\Component\HttpFoundation\ParameterBag  $bag
     * @return void
     */
    protected function tranformRequest(ParameterBag $bag)
    {
        $bag->replace($this->transformArray($bag->all()));
    }

    /**
     * Transform the data in the parameter bag.
     *
     * @param  \Symfony\Component\HttpFoundation\ParameterBag  $bag
     * @return void
     */
    protected function replaceFiles(ParameterBag $bag)
    {
        $bag->replace(array_merge($bag->all(), $this->files->all()));
    }

    /**
     * Transform the data in the given array.
     *
     * @param  array  $data
     * @param  string  $keyPrefix
     * @return array
     */
    protected function transformArray(array $data, $keyPrefix = '')
    {
        return collect($data)->map(function ($value, $key) use ($keyPrefix) {
            return $this->transformValue($keyPrefix . $key, $value);
        })->filter()->all();
    }

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transformValue($key, $value)
    {
        if (is_array($value)) {
            return $this->transformArray($value, $key . '.');
        }

        return $this->transform($key, $value);
    }

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        if ($this->isBase64String($value)) {
            $file = $this->fromBase64ToFile($value);

            $this->files->set($key, $file);

            return;
        }

        return $value;
    }

    /**
     * Check is given value is Base64 encoded string
     *
     * @param string $value
     * @return boolean
     */
    protected function isBase64String($value) {
        return preg_match("/^data:((?:\w+|\w.+)\/(?:\w+|\w.+));[ b]ase64/", $value);
    }

    /**
     * Create a new UploadedFile instance from Base64 encoded string
     *
     * @param string $value
     * @return \Illuminate\Http\UploadedFile
     */
    public function fromBase64ToFile($value)
    {
        $encodedFile = new Base64EncodedFile($value);

        $path = $encodedFile->getRealPath();
        $name = $encodedFile->getFilename();
        $type = $encodedFile->getMimeType();

        return new UploadedFile($path, $name, $type);
    }
}