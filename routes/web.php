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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pay', 'HomeController@pay')->name('pay');
Route::get('/onReturn', 'HomeController@onReturn');
Route::any('/onNotify', 'HomeController@onNotify');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

PaymentService::routes();
PaymentService::adminRoutes();
