<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');
        if ($request->segment(1)) {
            if (in_array($request->segment(1), config('app.enabled_locales'))) {
                $locale = $request->segment(1);
                app()->setLocale($locale);
            }
        }
        URL::defaults(['locale' => $locale]);
        $request->route()->forgetParameter('locale');
        return $next($request);
    }
}