<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 19.08.2019
 * Time: 16:42
 */

use App\Http\Controllers\Site\TenderController;

Route::view('/advertising/banners-ad', 'site.pages.static.banners_ad');
Route::view('/advertising/cooler-ad', 'site.pages.static.cooler_ad');
Route::view('/advertising', 'site.pages.static.home');
Route::view('/advertising/info-flayers', 'site.pages.static.info_flayers');
Route::view('/advertising/package-ad', 'site.pages.static.package_ad');
Route::view('/advertising/promo', 'site.pages.static.promo');
Route::view('/advertising/tablets-ad', 'site.pages.static.tablets_ad');
Route::view('/advertising/tv-videos', 'site.pages.static.tv_videos');
Route::view('/advertising/visit-card', 'site.pages.static.visit_card');

Route::redirect('/dosug', '/leisure');
Route::redirect('/magaziny', '/the-shops');
Route::redirect('/uslugi', '/Services');
Route::redirect('/dlya-biznesa', '/for-business');
Route::redirect('/servisy', '/for-citizens');
Route::namespace('Site')->group(function () {
    Route::get('/ban2', 'BannerController@index');
});

Route::middleware('needsList')->namespace('Site')->group(function () {
    Route::get('/cgu-info', 'CguController@cguInfo')->name('home.cgu.info');
    Route::get('/cgu-info/{id}', 'CguController@cguCategory')->name('home.cgu.info.category');
    Route::get('/cgu-ad', 'CguController@cguAd')->name('home.cgu.ad');
    Route::get('/cgu-ad/{id}', 'CguController@cguCategory')->name('home.cgu.ad.category');
});

Route::prefix('api')->group(function () {
    Route::post('/messages', 'Site\ChatsController@sendMessage');
    Route::get('/messages', 'Site\ChatsController@fetchMessages');
});

Route::middleware('needsList')->name('site.')->namespace('Site')->group(function () {
    // Studio static page routes
    Route::view('/studiya', 'studio.home', ['page' => 'home']);
    Route::view('/site', 'studio.site.index', ['page' => 'site']);
    Route::view('/site/lange', 'studio.site.landing', ['page' => 'site.landing']);
    Route::view('/site/internet-magazin', 'studio.site.eshop', ['page' => 'site.eshop']);
    Route::view('/site/korp', 'studio.site.korp', ['page' => 'site.korp']);
    Route::view('/development/site/catalog', 'studio.development.catalog', ['page' => 'dev.site.catalog']);
    Route::view('/development/mobile-app/android', 'studio.development.android', ['page' => 'dev.mobile.android']);
    Route::view('/development/mobile-app/ios', 'studio.development.ios', ['page' => 'dev.mobile.ios']);
    Route::view('/development/bot', 'studio.development.bot', ['page' => 'dev.bot']);
    Route::view('/prodvizhenie-seo', 'studio.seo.index', ['page' => 'seo']);
    Route::view('/prodvizhenie-seo/optimizatsiya', 'studio.seo.optimization', ['page' => 'seo.optimization']);
    Route::view('/smm', 'studio.smm', ['page' => 'smm']);
    Route::view('/lets-talk', 'studio.contacts', ['page' => 'contacts']);
    Route::view('/b2b', 'site.pages.b2b')->name('b2b');

    //Info page
    Route::view('/info', 'site.pages.info');

    // Blog route
    Route::get('/blog', 'BlogController@index')->name('blog.index');
    Route::get('/blog/{params}', 'BlogController@blog')->where('params', '.+')->name('blog.main');

    // Account routes
    Route::get('/account', 'AccountController@index')->name('account.index');
    Route::get('/account/notifications/markAsRead', 'AccountController@markNotificationsAsRead')->name('account.notifications.read');
    Route::get('/account/create', 'AccountController@create');
    Route::post('/account/create', 'AccountController@store');
    Route::post('/account/contractor/profile/save', 'AccountController@savePersonalContractor')->name('account.contractor.profile.save');
    Route::get('/account/professional', 'AccountController@professional')->name('account.contractor.professional');
    Route::post('/account/professional', 'AccountController@saveProfessional');
    Route::post('/account/customer/profile/save', 'AccountController@saveCustomerProfile')->name('account.customer.profile.save');
    Route::middleware('phone.verified')->group(function() {
        Route::get('/account/tenders', 'AccountController@tenders')->name('account.tenders');
        Route::get('/account/portfolio', 'FileController@index')->name('account.portfolio');
        Route::post('/account/portfolio/save', 'FileController@save')->name('account.portfolio.save');
        Route::get('/account/tenders/{slug}/edit', 'AccountController@editTender')->name('account.tenders.edit');
        Route::get('/account/tenders/{slug}/candidates', 'AccountController@tenderCandidates')->name('account.tenders.candidates');
        Route::get('/account/chats', 'ChatsController@index')->name('account.chats');
        Route::post('/account/chats', 'ChatsController@createChat')->name('account.chats.create');
        Route::get('/account/comment', 'CommentController@index')->name('account.comment');
        Route::post('/account/comment', 'CommentController@createCommentAll')->name('account.comment.create');
        Route::get('/account/purse', 'PurseController@index')->name('account.purse');
    });

    // Tenders routes
    Route::middleware('phone.verified')->group(function() {
        Route::get('/tenders/create', 'TenderController@create')->name('tenders.common.create');
        Route::post('/tenders/create', 'TenderController@store');
        Route::post('/tenders/makeRequest', 'TenderController@makeRequest')->name('tenders.requests.make');
        Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest')->name('tenders.requests.cancel');
        Route::delete('/tenders/{id}/delete', 'TenderController@delete')->name('tenders.delete');
        Route::post('/tenders/{id}/update', 'TenderController@update')->name('tenders.edit');
        Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest')->name('tenders.accept');
        Route::patch('/tenders/email-subscription/{tender}', 'TenderController@emailSubscription')->name('tenders.email-subscription');
    });
    Route::get('/tenders', 'TenderController@index')->name('tenders.index');
    Route::post('/tenders/search', 'TenderController@searchTender')->name('tenders.index.search');
    Route::get('/tenders/{params}', 'TenderController@category')->where('params', '.+')->name('tenders.category');

    Route::prefix('/tender/maps')->name('maps.')->group(function () {
        Route::get('/', [TenderController::class,'maps'])->name('index');
        Route::post('filter', [TenderController::class,'ajaxFilter'])->name('filter') ;
    });

    Route::get('/', 'HomeController@index')->name('catalog.index');
    Route::get('/contractors', 'ContractorsController@index')->name('contractors.index');
    Route::get('/contractors/category/{params}', 'ContractorsController@category')->where('params', '.+')->name('catalog.main');
    Route::get('/contractors/addContractor/{contractorId}/to/{tenderId}', 'ContractorsController@addContractor')->name('tenders.contractors.add');
    Route::get('/contractors/addContractorGuest/clear', 'ContractorsController@deleteAllContractorsFromSession')->name('tenders.contractors.clear');
    Route::get('/contractors/addContractorGuest/{contractorId}', 'ContractorsController@addContractorForNonAuth')->name('tenders.contractors.add.guest');
    Route::get('/contractors/addContractorGuest/remove/{contractorId}', 'ContractorsController@deleteContractorFromSession')->name('tenders.contractors.delete');
    Route::get('/contractors/{slug}', 'ContractorsController@contractor')->name('contractors.show');
    Route::post('/contractors/comment', 'CommentController@createCommentContractor')->name('contractors.comment.contractor');
    Route::post('/contractors/search', 'ContractorsController@contractorSearch')->name('contractors.search');

    // Route::get('/{params}', 'ContractorsController@category')->where('params', '.+')->name('catalog.main');
    Route::post('/search', 'CatalogController@search')->name('catalog.search');
    Route::post('/live-search', 'CatalogController@ajax_search');
    Route::post('/chat-search', 'ChatsController@searchChat')->name('chats.search');
});
