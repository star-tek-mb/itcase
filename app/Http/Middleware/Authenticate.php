<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (substr($request->path(), 0, 3) === "api" && Auth::guard('sanctum')->guest()) {
            return response()->json(['message' => 'Выполните вход']);
        }
        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        return route('login', ['locale' => app()->getLocale()]);
    }
}
