<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {

    //Login & Register
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

    // Account routes
    Route::get('/account', 'AccountController@index');
    Route::get('/account/notifications/markAsRead', 'AccountController@markNotificationsAsRead');
    Route::get('/account/create', 'AccountController@create');
    Route::post('/account/create', 'AccountController@store');
    Route::post('/account/contractor/profile/save', 'AccountController@savePersonalContractor');
    Route::get('/account/professional', 'AccountController@professional');
    Route::post('/account/professional', 'AccountController@saveProfessional');
    Route::post('/account/customer/profile/save', 'AccountController@saveCustomerProfile');
    Route::middleware('phone.verified')->group(function () {
        Route::get('/account/tenders/{user_id}', 'AccountController@tenders');
        Route::get('/account/portfolio', 'FileController@index');
        Route::post('/account/portfolio/save', 'FileController@save');

        Route::post('/account/chats', 'ChatsController@createChat');
        Route::get('/account/comment', 'CommentController@index');
        Route::post('/account/comment', 'CommentController@createCommentAll');
    });

    // Tenders routes
    Route::middleware('phone.verified')->group(function () {
        Route::get('/tenders/{id}', 'TenderController@tender');
        Route::post('/tenders/create', 'TenderController@store');
        Route::get('/tenders/user','TenderController@tendersOfUser' );
        Route::post('/tenders/makeRequest', 'TenderController@makeRequest');
        Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest');
        Route::delete('/tenders/{id}/delete', 'TenderController@delete');
        Route::post('/tenders/{id}/update', 'TenderController@update');
        Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest');
        Route::post('/tenders/showOffered', 'TenderController@showOffered');
        Route::post('/tenders/showRequested', 'TenderController@showRequested');
    });
    Route::get('/tenders', 'TenderController@index');
    Route::post('/tenders/maps-filter', 'TenderController@mapsFilter');
    Route::post('/tenders/text-filter', 'TenderController@textFilter');
    Route::post('/tenders/search', 'TenderController@searchTender');
    Route::get('/tenders/category/{id}', 'TenderController@category');

    //Categories For Tender Create
    Route::get('/tenders/create/category', 'TenderController@categoryCreateTender');

    // Contractors routes
    Route::get('/contractors', 'ContractorsController@index');
    Route::get('/contractors/category/{id}', 'ContractorsController@category');
    Route::get('/contractors/addContractor/{contractorId}/to/{tenderId}', 'ContractorsController@addContractor');
    Route::get('/contractors/{id}', 'ContractorsController@contractor');
    Route::post('/contractors/comment', 'CommentController@createCommentContractor');
    Route::post('/contractors/search', 'ContractorsController@contractorSearch');

    Route::post('/phone/verify', 'AuthController@verify');
    // Phone verify routes

    Route::middleware('throttle:6,1', function () {

        Route::post('/phone/resend', 'AuthController@resend');
    });

    Route::get('/catalog', 'HomeController@index');
    Route::post('/search', 'CatalogController@search');
    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{params}', 'BlogController@blog')->where('params', '.+');
    Route::post('/messages', 'ChatsController@sendMessage');
    Route::get('/messages/read/{chat_id}', 'ChatsController@fetchMessages');
    Route::get('/messages/{chat_id}/{message_id}', 'ChatsController@updateChat');
    Route::get('/messages/notificationLastMessages', 'ChatsController@notificationLastMessages'); // for notificaiton
    Route::post('/messages/read/messagesIsRead', 'ChatsController@messagesIsRead');
    Route::put('/messages/read/messagesIsRead', 'ChatsController@messagesIsRead');
    Route::get('/account/chats/{chat_id}', 'ChatsController@index');
    Route::get('/account/all_chats', "ChatsController@allChats");
});
