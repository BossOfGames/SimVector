<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirportController extends Controller
{
    public function getAirport($icao) {
        $airport = DB::connection('mongodb')->collection('airports')->where('gps_code', $icao)->first();
        $charts = DB::connection('mongodb')->collection('charts')->where('icao', $icao)->first();
        return response()->json(['airport' => $airport, 'charts' => $charts, 'cycle' => '1907']);
    }
    public function getDepArr($icao) {
        $dep = DB::connection('mongodb')->collection('flights')->where('dep_icao', $icao)->where('state', 1)->get();
        $arr = DB::connection('mongodb')->collection('flights')->where('arr_icao', $icao)->where('state', 1)->get();
        return response()->json(['dep' => $dep, 'arr' => $arr]);
    }
}
