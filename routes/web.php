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

Route::get('/old', function () {
    return view('map');
});
Route::get('/map', function () {
    return view('map2');
});
Route::get('/test', function () {
    return view('test');
});
Route::get('/', function () {
    return view('map2');
});
Route::get('/embed', function () {
    return view('embeds');
});
Route::get('/engine', function () {
    return view('engine');
});
Route::get('/embed/{id}', 'MapEmbedController@index');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
