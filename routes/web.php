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
    return view('map');
});
Route::get('/afv', function () {
    return view('afv');
});
Auth::routes();
Route::get('php', function () {
    phpinfo();
});
Route::get('/home', 'HomeController@index')->name('home');
