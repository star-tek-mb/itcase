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
    Route::get('/account/seeAccount/{user_id}', 'AccountController@index');
    Route::get('/account/notifications/markAsRead', 'AccountController@markNotificationsAsRead');
    Route::get('/account/create', 'AccountController@create');
    Route::post('/account/create', 'AccountController@store');
    Route::post('/account/contractor/profile/save', 'AccountController@savePersonalContractor');
    Route::get('/account/professional', 'AccountController@professional');
    Route::post('/account/professional', 'AccountController@saveProfessional');
    Route::post('/account/customer/profile/save', 'AccountController@saveCustomerProfile');
    Route::middleware('phone.verified')->group(function () {

        //new add routes for account about tenders
        Route::get('/account/tenders', 'AccountController@tenders');
        Route::get('/account/myTenders/finishedTenders' , 'AccountController@finishedTenders');
        Route::get('/account/myTenders/onModerationTenders' , 'AccountController@onModerationTenders');

        //my tenders only short id and title for inviting contractor
        Route::get('/account/myTenders/short/{contractorID}','AccountController@shortTenders');

        Route::get('/account/portfolio', 'FileController@index');
        Route::post('/account/portfolio/save', 'FileController@save');

        Route::post('/account/chats', 'ChatsController@createChat');
        Route::get('/account/comment', 'CommentController@index');
        Route::post('/account/comment', 'CommentController@createCommentAll');

        // routes for requests contractor send request to consumer
        Route::get('/account/myRequest/requestsAccepted', 'AccountController@requestsAccepted');
        Route::get('/account/myRequest/requestsSend', 'AccountController@requestsSend');

        // Account guest tenders
        Route::get('/account/guest/tenders/{user_id}', 'AccountController@guestTenders');
    });

    // Tenders routes
    Route::middleware('phone.verified')->group(function () {
        Route::get('/tenders/{id}', 'TenderController@tender');
        Route::post('/tenders/create', 'TenderController@store');
        Route::get('/tenders/user','TenderController@tendersOfUser' );
        Route::post('/tenders/makeRequest', 'TenderController@makeRequest');
        Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest');
        Route::match(['delete','put'],'/tenders/{id}/delete', 'TenderController@delete');
        Route::post('/tenders/update/{id}', 'TenderController@update');
        Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest');
        Route::post('/tenders/showOffered', 'TenderController@showOffered');
        Route::post('/tenders/showRequested', 'TenderController@showRequested');
    });

    //New added
    Route::get('/tenders', 'TenderController@index');

    //Added only opened tenders
    Route::get('/tenders/show/opened' , 'TenderController@openedTenders');


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

    //comments to get comment of particular user
    Route::get('/contractors/comment/{id}', 'CommentController@getCommentsOfUser');


    Route::post('/contractors/comment', 'CommentController@createCommentContractor');
    Route::post('/contractors/search', 'ContractorsController@contractorSearch');

    // Phone verify routes
    Route::post('/phone/verify', 'AuthController@verify');
    Route::post('/phone/resend', 'AuthController@resend');



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
    Route::get('/chats/all/get', "ChatsController@allChats");
});
