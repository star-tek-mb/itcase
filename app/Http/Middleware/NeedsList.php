<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\HandbookCategory;
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
        $parentCategories = HandbookCategory::where('parent_id', null)->orderBy('position', 'asc')->get();
        View::share('parentCategories', $parentCategories);
        return $next($request);
    }
}
