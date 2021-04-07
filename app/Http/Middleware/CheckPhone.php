<?php

namespace App\Http\Middleware;

use Closure;

class CheckPhone
{

    public function handle($request, Closure $next)
    {
        if ($request->is('phone/*')) {
            return $next($request);
        }

        $user = auth()->user();
        if ($user && $user->getPhoneForVerification() && !$user->hasVerifiedPhone()) {
            if (substr($request->path(), 0, 3) === "api") {
                return response()->json(['message' => ['Подтвердите номер телефона']]);
            } else {
                return redirect('/phone/verify');
            }
        }
        return $next($request);
    }

}