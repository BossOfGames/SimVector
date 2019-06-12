<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VatsimDataController extends Controller
{
    public function getFlights()
    {
        $flights = Flight::where('state', '<', 2)->get();
        return response()->json($flights);
    }
    public function getFlightsAFV()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://afv-beta.vatsim.net/vatsim-data', [
        ])->getBody()->getContents();
        return response()->json(json_decode($res));
    }
}
