<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HandbookCategory;
use App\Models\BlogPost;
use App\Models\Vacancy;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('site.*', function ($view) {
            $parentCategories = HandbookCategory::where('parent_id', null)->orderBy('position', 'asc')->get();
            $view->with('parentCategories', $parentCategories);

            $posts = BlogPost::latest()->take(5)->get();
            $view->with('posts', $posts);

            $vacancies = Vacancy::latest()->take(5)->get();
            $view->with('vacancies', $vacancies);
        });
    }
}
