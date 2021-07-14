<?php


Route::get('/failrobokassa', [\App\Http\Controllers\Payments\RobokassaController::class, 'failUrlView'])->name('payment.fail');
Route::get('/resultrobokassa', [\App\Http\Controllers\Payments\RobokassaController::class, 'successURLView'])->name('payment.success');
Route::name('site.')->namespace('Site')->group(function () {
    // Blog route
    Route::get('/blog', 'BlogController@index')->name('blog.index');
    Route::get('/blog/{params}', 'BlogController@blog')->where('params', '.+')->name('blog.main');

    // Account routes
    Route::get('/account', 'AccountController@index')->name('account.index');
    Route::get('/account/notifications/markAsRead', 'AccountController@markNotificationsAsRead')->name('account.notifications.read');
    Route::get('/account/create', 'AccountController@create')->name('account.create');
    Route::post('/account/create', 'AccountController@store');
    Route::post('/account/contractor/profile/save', 'AccountController@savePersonalContractor')->name('account.contractor.profile.save');
    Route::get('/account/professional', 'AccountController@professional')->name('account.contractor.professional');
    Route::post('/account/professional', 'AccountController@saveProfessional');
    Route::post('/account/customer/profile/save', 'AccountController@saveCustomerProfile')->name('account.customer.profile.save');
    Route::get('/account/payment',[\App\Http\Controllers\Payments\RobokassaController::class,'payment'])->name('account.payment');
    Route::middleware(['phone.verified', 'pay.made'])->group(function () {

        Route::get('/account/tenders', 'AccountController@tenders')->name('account.tenders');
        Route::get('/account/tenders/requests', 'AccountController@tendersRequests')->name('account.tenders.requests');
        Route::get('/account/portfolio', 'FileController@index')->name('account.portfolio');
        Route::post('/account/portfolio/save', 'FileController@save')->name('account.portfolio.save');
        Route::get('/account/tenders/{slug}/edit', 'AccountController@editTender')->name('account.tenders.edit');
        Route::get('/account/tenders/{slug}/candidates', 'AccountController@tenderCandidates')->name('account.tenders.candidates');
        Route::get('/account/chats', 'ChatsController@index')->name('account.chats');
        Route::post('/account/chats', 'ChatsController@createChat')->name('account.chats.create');
        Route::get('/account/comment', 'CommentController@index')->name('account.comment');
        Route::post('/account/comment', 'CommentController@createCommentAll')->name('account.comment.create');
    });

    // Tenders routes
    Route::middleware(['phone.verified', 'pay.made'])->group(function () {
        Route::get('/tenders/create', 'TenderController@create')->name('tenders.common.create');
        Route::post('/tenders/create', 'TenderController@store');
        Route::post('/tenders/makeRequest', 'TenderController@makeRequest')->name('tenders.requests.make');
        Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest')->name('tenders.requests.cancel');
        Route::delete('/tenders/{id}/delete', 'TenderController@delete')->name('tenders.delete');
        Route::post('/tenders/{id}/update', 'TenderController@update')->name('tenders.edit');
        Route::post('/tenders/{id}/check', 'TenderController@checkContractor')->name('tenders.check');
        Route::post('/tenders/{id}/complete', 'TenderController@completeCustomer')->name('tenders.complete');
        Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest')->name('tenders.accept');
        Route::patch('/tenders/email-subscription/{tender}', 'TenderController@emailSubscription')->name('tenders.email-subscription');
    });
    Route::get('/tenders', 'TenderController@index')->name('tenders.index');
    Route::post('/tenders/search', 'TenderController@searchTender')->name('tenders.search');
    Route::get('/tenders/map', 'TenderController@map')->name('tenders.map');
    Route::get('/tenders/{params}', 'TenderController@category')->where('params', '.+')->name('tenders.category');

    Route::match(['get','post'],'/', 'HomeController@index')->name('catalog.index');
    Route::get('/contractors', 'ContractorsController@index')->name('contractors.index');
    Route::post('/contractors/categories', 'ContractorsController@contractorCategory')->name('contractors.categories');
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
    Route::post('/live-search', 'CatalogController@ajax_search')->name('catalog.live-search');
    Route::post('/chat-search', 'ChatsController@searchChat')->name('chats.search');

    Route::get('/{params}', 'HomeController@page')->where('params', '.+')->name('page');
});
