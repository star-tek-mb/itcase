<?php

namespace App\Http\Middleware;

use Closure;

class CheckCompletedAccountMiddleware
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
        if (substr($request->path(), 0, 3) === "api") {
            if ($user) {
                if ($user->checkCompletedAccount()) {
                    if ($user->hasRole('contractor') && $user->categories()->count() == 0 && $request->path() !== 'api/account/professional') {
                        return response()->json(['message' => ['Выберите услуги которые вы предоставляете']]);
                    }
                    return $next($request);
                } else {
                    return response()->json(['message' => ['Для начала заполните данные']]);
                }
            }
            return response()->json(['message' => ['Войдите в аккаунт']]);
        } else {
            if ($user) {
                if ($user->checkCompletedAccount()) {
                    if ($user->hasRole('contractor') && $user->categories()->count() == 0 && $request->route()->getName() != 'site.account.contractor.professional') {
                        return redirect(route('site.account.contractor.professional'))->with('account.warning', 'Выберите услуги, которые вы предоставляете');
                    }
                    return $next($request);
                } else {
                    return redirect(route('site.account.create'))->with('warning', 'Для начала заполните данные');
                }
            }
            return redirect()->route('login');
        }
    }
}
