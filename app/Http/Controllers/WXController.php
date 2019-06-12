<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class WXController extends Controller
{
    public function metar($icao, Request $request) {
        $client = new Client();
        /*
        $response = $client->get('https://www.aviationweather.gov/adds/dataserver_current/httpparam', [
            'query' => [
                'dataSource' => 'metars',
                'requestType' => 'retrieve',
                'format' => 'xml',
                'stationString' => $request->get('icao'),
                'hoursBeforeNow' => 1
            ]
        ]);
        $xml = $response->getBody()->getContents();
        return Response::make($xml, '200');
        */
        $response = $client->get('https://avwx.rest/api/metar/'.$icao.'?format=json&onfail=cache');
        $metar = json_decode($response->getBody()->getContents());
        return response()->json($metar);
    }
    public function taf($icao, Request $request) {
        $client = new Client();
        $response2 = $client->get('https://avwx.rest/api/taf/'.$icao.'?format=json&onfail=cache');
        $taf = json_decode($response2->getBody()->getContents());
        return response()->json($taf);
    }
    public function allWX($icao, Request $request) {
        $client = new Client();
        $response = $client->get('https://avwx.rest/api/metar/'.$icao.'?format=json&onfail=cache');
        $metar = json_decode($response->getBody()->getContents());

        $response2 = $client->get('https://avwx.rest/api/taf/'.$icao.'?format=json&onfail=cache');
        $taf = json_decode($response2->getBody()->getContents());

        return response()->json([
            'metar' => $metar,
            'taf' => $taf
        ]);
    }
}
