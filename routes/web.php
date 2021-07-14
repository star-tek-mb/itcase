<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::post('/successrobokassa', [\App\Http\Controllers\Payments\RobokassaController::class, 'successURL']);
Route::post('/failrobokassa', [\App\Http\Controllers\Payments\RobokassaController::class, 'failUrl']);

Route::prefix('{locale}')->where(['locale' => '(' . implode('|', config('app.enabled_locales')) . ')'])->middleware('setlocale')->group(function () {
    include __DIR__ . '/registration.php';
    include __DIR__ . '/front.php';
});

include __DIR__ . '/admin.php';

Route::prefix('site')->group(function () {
    Route::post('/messages', 'Site\ChatsController@sendMessage');
    Route::get('/messages', 'Site\ChatsController@fetchMessages');
});
Route::view('/thanks', 'site.pages.thanks');
Route::get('/auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('/auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('/auth/telegram/callback', 'Site\AccountController@telegramCallback');

Route::get('{any}', function () {
    return redirect(app()->getLocale() . '/' . request()->path());
})->where(['any' => '(?!(' . implode('|', config('app.enabled_locales')) . ')).*']);
