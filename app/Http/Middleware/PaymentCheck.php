<?php

namespace App\Http\Middleware;

use Closure;

class PaymentCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
            if ($user && $user->notPayForAccount()) {
                return redirect()->route('site.account.payment');
            }
        return $next($request);
    }
}
