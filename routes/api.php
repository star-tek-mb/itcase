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

    });




});
