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
Route::namespace('Api')->group(function() {

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
    Route::get('/account/tenders', 'AccountController@tenders');
    Route::get('/account/tenders/{slug}/edit', 'AccountController@editTender');
    Route::get('/account/tenders/{slug}/candidates', 'AccountController@tenderCandidates');
    Route::get('/account/portfolio', 'FileController@index');
    Route::post('/account/portfolio/save', 'FileController@save');
    Route::get('/account/chats', 'ChatsController@index');
    Route::post('/account/chats', 'ChatsController@createChat');
    Route::get('/account/comment', 'CommentController@index');
    Route::post('/account/comment', 'CommentController@createCommentAll');

    // Tenders routes
    Route::get('/tenders', 'TenderController@index');
    Route::post('/tenders/search', 'TenderController@searchTender');
    Route::get('/tenders/{params}', 'TenderController@category')->where('params', '.+');
    Route::post('/tenders/create', 'TenderController@store');
    Route::post('/tenders/makeRequest', 'TenderController@makeRequest');
    Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest');
    Route::delete('/tenders/{id}/delete', 'TenderController@delete');
    Route::post('/tenders/{id}/update', 'TenderController@update');
    Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest');

    // Contractors routes
    Route::get('/contractors', 'ContractorsController@index');
    Route::get('/contractors/category/{params}', 'ContractorsController@category')->where('params', '.+');
    Route::get('/contractors/addContractor/{contractorId}/to/{tenderId}', 'ContractorsController@addContractor');
    Route::get('/contractors/addContractorGuest/clear', 'ContractorsController@deleteAllContractorsFromSession');
    Route::get('/contractors/addContractorGuest/{contractorId}', 'ContractorsController@addContractorForNonAuth');
    Route::get('/contractors/addContractorGuest/remove/{contractorId}', 'ContractorsController@deleteContractorFromSession');
    Route::get('/contractors/{slug}', 'ContractorsController@contractor');
    Route::post('/contractors/comment', 'CommentController@createCommentContractor');
    Route::post('/contractors/search', 'ContractorsController@contractorSearch');

    Route::get('/catalog', 'HomeController@index');
    Route::post('/search', 'CatalogController@search');
    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{params}', 'BlogController@blog')->where('params', '.+');
    Route::post('/messages', 'Site\ChatsController@sendMessage');
    Route::get('/messages', 'Site\ChatsController@fetchMessages');
});
