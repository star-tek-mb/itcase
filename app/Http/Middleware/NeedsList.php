<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\NeedType;
use Illuminate\Support\Facades\View;

class NeedsList
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
        $needs = NeedType::orderBy('position', 'asc')->get();
        View::share('needs', $needs);
        return $next($request);
    }
}
