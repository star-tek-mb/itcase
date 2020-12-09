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
        if ($user) {
            if ($user->checkCompletedAccount()) {
                if ($user->hasRole('contractor') && $user->categories()->count() == 0 && $request->path() !== 'account/professional')
                    return redirect('/account/professional')->with('account.warning', 'Выберите услуги, которые вы предоставляете');
                return $next($request);
            }
            else
                return redirect('/account/create')->with('warning', 'Для начала заполните данные');
        }

        return redirect()->route('login');
    }
}
