<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 19.08.2019
 * Time: 21:55
 */

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\CguCategoryRepositoryInterface',
            'App\Repositories\CguCategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\CguSiteRepositoryInterface',
            'App\Repositories\CguSiteRepository'
        );
        $this->app->bind(
            'App\Repositories\HandbookCategoryRepositoryInterface',
            'App\Repositories\HandbookCategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\CguCatalogRepositoryInterface',
            'App\Repositories\CguCatalogRepository'
        );

        $this->app->bind(
            'App\Repositories\BlogCategoryRepositoryInterface',
            'App\Repositories\BlogCategoryRepository'
        );

        $this->app->bind(
            'App\Repositories\BlogPostRepositoryInterface',
            'App\Repositories\BlogPostRepository'
        );

        $this->app->bind(
            'App\Repositories\CompanyRepositoryInterface',
            'App\Repositories\CompanyRepository'
        );

        $this->app->bind(
            'App\Repositories\UserClickRepositoryInterface',
            'App\Repositories\UserClickRepository'
        );

        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\NeedTypeRepositoryInterface',
            'App\Repositories\NeedTypeRepository'
        );

        $this->app->bind(
            'App\Repositories\ServiceRepositoryInterface',
            'App\Repositories\ServiceRepository'
        );
        $this->app->bind(
            'App\Repositories\MenuRepositoryInterface',
            'App\Repositories\MenuRepository'
        );
        $this->app->bind(
            'App\Repositories\FaqRepositoryInterface',
            'App\Repositories\FaqRepository'
        );
        $this->app->bind(
            'App\Repositories\TenderRepositoryInterface',
            'App\Repositories\TenderRepository'
        );
        $this->app->bind(
            'App\Repositories\ChatRepositoryInterface',
            'App\Repositories\ChatRepository'
        );
    }
}
