<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});
Route::post('register', 'AuthController@register');

//Account
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']],  function () {

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

    // Tenders routes
    Route::get('/tenders', 'TenderController@index');
    Route::post('/tenders/search', 'TenderController@searchTender');
    Route::get('/tenders/{params}', 'TenderController@category')->where('params', '.+');
    Route::post('/tenders/makeRequest', 'TenderController@makeRequest');
    Route::post('/tenders/cancelRequest', 'TenderController@cancelRequest');
    Route::delete('/tenders/{id}/delete', 'TenderController@delete');
    Route::post('/tenders/{id}/update', 'TenderController@update');
    Route::post('/tenders/{tenderId}/accept/{requestId}', 'TenderController@acceptTenderRequest');

    // Contractors routes
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
});

    Route::post('/search', 'CatalogController@search');

    // Blog route
    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{params}', 'BlogController@blog')->where('params', '.+');

    Route::get('/cgu-info', 'CguController@cguInfo');
    Route::get('/cgu-info/{id}', 'CguController@cguCategory');
    Route::get('/cgu-ad', 'CguController@cguAd');
    Route::get('/cgu-ad/{id}', 'CguController@cguCategory');

    Route::post('/messages', 'Site\ChatsController@sendMessage');
    Route::get('/messages', 'Site\ChatsController@fetchMessages');

});
