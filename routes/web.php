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
include __DIR__ . '/registration.php';
include __DIR__ . '/admin.php';
include __DIR__ . '/front.php';
Route::post('/ajax-search', 'HomeController@search');
