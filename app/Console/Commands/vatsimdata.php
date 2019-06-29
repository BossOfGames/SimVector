<?php

namespace App\Console\Commands;

use App\Events\VatsimUpdated;
use App\Models\Flight;
use App\Models\FlightData;
use App\Models\VatsimAtc;
use App\Models\VatsimFlight;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class vatsimdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vatsim:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run VATSIM data parse';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $res = $client->request('GET', 'http://info.vroute.net/vatsim-data.txt', [

        ])->getBody();

        $online_active = array();
        $online_prefile = array();
        $online_general = array();
        // TIme to parse this bitch for data. First, let's break out all the active clients. That's the only thing we're worried about.
        $data_lines = explode("\n", $res);
        // find the line with all the active data.
        $start_active = null;
        $start_prefile = null;
        $start_general = null;
        $acfOut = array();
        $atcOut = array();
        // Find where we need to start within the file to get the required data.
        foreach ($data_lines as $key=>$value)
        {
            if ($value === "!GENERAL:\r")
            {
                $start_general = $key;
                $start_general++;
                continue;
            }
            if ($value === "!CLIENTS:\r")
            {
                $start_active = $key;
                $start_active++;
                continue;
            }
            if ($value === "!PREFILE:\r")
            {
                $start_prefile = $key;
                $start_prefile++;
                continue;
            }
        }
        foreach ($data_lines as $key=>$line)
        {
            if ($key <= $start_general)
                continue;
            if ($line === ";\r")
                continue;
            if ($line === "!VOICE SERVERS:\r")
                break;
            array_push($online_general, explode(' = ', $line));
        }
        foreach ($data_lines as $key=>$line)
        {
            if ($key <= $start_active)
                continue;
            if ($line === ";\r")
                continue;
            if ($line === "!SERVERS:\r")
                break;
            array_push($online_active, explode(':', $line));
        }

        foreach ($data_lines as $key=>$line)
        {
            if ($key <= $start_prefile)
                continue;
            if ($line === ";\r" || $line === ";   END\r")
                continue;
            if ($line === "")
                continue;
            array_push($online_prefile, explode(':', $line));
        }
        foreach ($online_active as $data)
        {
            if ($data[3] === 'ATC') {
                array_push($atcOut, self::_processATC($data));
            } else {
                array_push($acfOut, self::_processFlight($data));
            }
        }
        file_put_contents('public/vatsimatc.json', json_encode($atcOut));
        file_put_contents('public/vatsimflights.json', json_encode($acfOut));
    }
    private function _processATC($data)
    {
        $regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;



            return [
                'cid' => intval($data[1]),
                'callsign' => $data[0],
                'facility' => intval($data[18]),
                'full_name' => $data[2],
                'frequency' => floatval($data[4]),
                'location' => [
                    'type' => 'Point',
                    'coordinates' => [floatval($data[6]), floatval($data[5])],
                ],
                'db_frequency' => DB::connection('mongodb')->collection('frequencies')
                    ->where('frequency', $data[4])
                    ->where('vatsim_prefix', explode('_', $data[0])[0])->first(),
                'rating' => intval($data[16]),
                'login_time' => preg_replace($regex, '$1', $data[37]),
                'visual_range' => intval($data[19]),
                'atis_message' => preg_replace($regex, '$1', $data[35])
            ];
    }
    private function _processFlight($data)
    {
        // First check to see if the flight exists currently.
        /*
        $flight = Flight::where('callsign', '=', $data[0])
            ->where('vatsim_cid', '=', intval($data[1]))
            ->where('state', '=', 1)
            ->with('flight_data')->first();

        // If the flight is not there, we need to create a new flight. Otherwise, use the flight we have and add position data.
        if (!$flight)
        {
        */
            $fn = explode(' ', $data[2]);
            $newFlight = new \stdClass();
            $newFlight->callsign = $data[0];
            $newFlight->vatsim_cid = intval($data[1]);
            $newFlight->full_name = $data[2];
            $newFlight->aircraft_type = $data[9];
            $newFlight->dep_icao = $data[11];
            $newFlight->flight_rules = intval(($data[21] === "I"? 1 : 0));
            $newFlight->cruise = intval($data[12]);
            $newFlight->arr_icao = $data[13];
            $newFlight->route = $data[30];
            $newFlight->state = 1;
            $newFlight->transponder = intval($data[17]);
            $newFlight->remarks = $data[29];
            $newFlight->heading = intval($data[38]);
            $newFlight->groundspeed = intval($data[8]);
            $newFlight->altitude = intval($data[7]);
            $newFlight->location = [
                'type' => 'Point',
                'coordinates' => [ floatval($data[6]), floatval($data[5]) ]
            ];
            //$newFlight->save();
            // now run the initial data.
        return $newFlight;

        /*
        $newFlight->flight_data()->create([
            'coordinates' => [floatval($data[6]), floatval($data[5])],
            'heading' => intval($data[38]),
            'altitude' => intval($data[7]),
            'groundspeed' => intval($data[8])
        ]);
    } else {
        $flight->dep_icao = $data[11];
        $flight->flight_rules = intval(($data[21] === "I"? 1 : 0));
        $flight->cruise = intval($data[12]);
        $flight->arr_icao = $data[13];
        $flight->route = $data[30];
        $flight->transponder = intval($data[17]);
        $flight->remarks = $data[29];
        $flight->heading = intval($data[38]);
        $flight->groundspeed = intval($data[8]);
        $flight->altitude = intval($data[7]);
        $flight->location = [
            'type' => 'Point',
            'coordinates' => [ floatval($data[6]), floatval($data[5]) ]
        ];
        $flight->flight_data()->create([
            'coordinates' => [floatval($data[6]), floatval($data[5])],
            'heading' => intval($data[38]),
            'altitude' => intval($data[7]),
            'groundspeed' => intval($data[8])
        ]);
        $flight->save();
    }
        */
    }
}
