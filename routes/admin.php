<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 19.08.2019
 * Time: 16:42
 */


Route::middleware('checkIsAdmin')->prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    // Dashboard
    Route::get('/', 'DashboardController@index')->name('index');
    // Cgu Site Routes
    Route::resource('/cgusites', 'CguSiteController');
    Route::get('/cgusites/{id}/removeimage', 'CguSiteController@removeImage')->name('cgusites.remove.image');
    Route::post('/cgusites/change/position', 'CguSiteController@changePosition')->name('cgusites.change.position');

    // BLOG Category Routes
    Route::resource('blogcategories', 'BlogCategoryController');
    Route::resource('blogposts', 'BlogPostController');

    // Cgu Category Routes
    Route::resource('/cgucategories', 'CguCategoryController');
    Route::get('/cgucategories/{id}/removeimage', 'CguCategoryController@removeImage')->name('cgucategories.remove.image');
    Route::get('/cgucategories/{id}/sites', 'CguCategoryController@sites')->name('cgucategories.sites');
    Route::get('/cgucategories/{id}/files', 'CguCategoryController@files')->name('cgucategories.files');
    Route::post('/cgucategories/change/position', 'CguCategoryController@changePosition')->name('cgucategories.change.position');

    // Cgu Catalog Routes
    Route::resource('/cgucatalogs', 'CguCatalogController');
    Route::get('/cgucatalogs/{id}/removefile', 'CguCatalogController@removeFile')->name('cgucatalogs.remove.file');
    Route::post('/cgucatalogs/change/position', 'CguCatalogController@changePosition')->name('cgucatalogs.change.position');

    // Handbook Category Routes
    Route::resource('/categories', 'HandbookCategoryController');
    Route::get('/categories/{id}/removeImage', 'HandbookCategoryController@removeImage')->name('categories.remove.image');
    Route::post('/categories/position', 'HandbookCategoryController@changePosition')->name('categories.change.position');
    Route::get('/categories/{id}/companies', 'HandbookCategoryController@companies')->name('categories.companies');
    Route::get('/categories/{id}/tenders', 'HandbookCategoryController@tenders')->name('categories.tenders');

    // Tenders routes

    Route::resource('/tenders', 'TenderController');
    Route::post('/tenders/{id}/requests/create', 'TenderController@createRequest')->name('tenders.requests.create');
    Route::get('/tenders/{id}/publish', 'TenderController@publishTender')->name('tenders.publish');
    Route::get('/tenders_all', 'TenderController@allTenders')->name('tenders.all');

    // Companies Routes
    Route::resource('/companies', 'CompanyController');
    Route::get('/companies/{id}/removeImage', 'CompanyController@removeImage')->name('companies.remove.image');
    Route::post('/companies/position', 'CompanyController@changePosition')->name('companies.change.position');

    // Users routes
    Route::resource('/users', 'UserController');
    Route::post('/users/{id}/changePassword', 'UserController@changePassword')->name('users.change.password');
    Route::get('/users/{id}/statistics', 'UserController@userStatistics')->name('users.statistics');

    // Type of needs routes
    Route::resource('/needs', 'NeedTypeController');
    Route::get('/needs/{id}/menu', 'NeedTypeController@menu')->name('needs.menu');
    Route::post('/needs/position', 'NeedTypeController@changePosition')->name('needs.change.position');
    Route::resource('/menu', 'MenuItemController');
    Route::get('/menu/{id}/removeImage', 'MenuItemController@removeImage')->name('menu.remove.image');

    // Services routes
    Route::resource('/services', 'ServiceController');
    Route::get('/services/{id}/removeImage', 'ServiceController@removeImage')->name('services.remove.image');

    // Banners routes
    Route::resource('/banners', 'BannerController');

    // FAQ routes
    Route::resource('/faq', 'FaqController');

    // Popular services
    Route::resource('popular', 'PopularServicesController');
    Route::get('/popular/{id}/removeImage', 'PopularServicesController@removeImage')->name('popular.remove.image');

    Route::resource('vacancyCategory', 'VacancyCategoryController');
    Route::resource('vacancy', 'VacancyController');

    Route::resource('pages', 'PageController');
    Route::resource('howtos', 'HowtoController');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    Auth::routes(['verify' => true]);
});
