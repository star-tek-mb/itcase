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
Route::prefix('{locale}')->where(['locale' => '(' . implode('|', config('app.enabled_locales')) . ')'])->middleware('setlocale')->group(function () {
    include __DIR__ . '/registration.php';
    include __DIR__ . '/front.php';
});
Route::get('/', function () {
    return redirect(config('app.locale'));
});

include __DIR__ . '/admin.php';

// TODO???
Route::post('/ajax-search', 'HomeController@search');
