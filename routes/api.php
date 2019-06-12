<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/wx/metar/{icao}', 'WXController@metar');
Route::get('/wx/taf/{icao}', 'WXController@metar');
Route::get('/wx/all/{icao}', 'WXController@allWX');
Route::get('/airport/{icao}', 'AirportController@getAirport');
Route::get('/flights/vatsim', 'VatsimDataController@getFlights');
Route::get('/flights/vatsim_afv', 'VatsimDataController@getFlightsAFV');
Route::get('/flights/vatsim/{icao}', 'AirportController@getDepArr');
