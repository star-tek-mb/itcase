<?php

use Illuminate\Support\Facades\Route;

Route::get('/registration', function () {
    return view('registration.register');
})->name('register');

Route::get('/login', function () {
    return view('registration.login');
})->name('login');

Route::get('/password/reset', function () {
    return view('registration.email');
})->name('password.request');

Route::post('/registration', 'Auth\RegisterController@register');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/login', 'Auth\LoginController@login');

Route::post('/password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');

Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::get('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

Route::middleware('auth')->group(function() {
    Route::get('/phone/verify', 'Auth\PhoneVerificationController@show')->name('phone.verification.notice');
    Route::middleware('throttle:6,1')->group(function() {
        Route::post('/phone/resend', 'Auth\PhoneVerificationController@resend')->name('phone.verification.resend');
        Route::post('/phone/verify', 'Auth\PhoneVerificationController@verify')->name('phone.verification.verify');
    });
});
