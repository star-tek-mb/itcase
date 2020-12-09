<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user)
            if ($user->hasRole('admin'))
                return $next($request);
        return redirect()->route('admin.login');
    }
}
