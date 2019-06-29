<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\VatsimAtc;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CloseNetworkFlights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            if ($key <= $start_active)
                continue;
            if ($line === ";\r")
                continue;
            if ($line === "!SERVERS:\r")
                break;
            array_push($online_active, explode(':', $line));
        }
        // Now it's time to parse ALL the flights and controllers to see if we have them as connected when they're not.
        $atc = VatsimAtc::all();
        $flights = Flight::where('state', '<=', 1)->get();
        //dd($flights->count());
        // First, controllers.
        foreach ($atc as $controller) {
            $found = false;
            foreach ($online_active as $data) {
                if ($data[3] === 'PILOT')
                    continue;

                if ($controller->cid === intval($data[1]) && $controller->callsign === $data[0]) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                VatsimAtc::destroy($controller->_id);
            }
        }

        foreach ($flights as $flight) {
            $found = false;
            foreach ($online_active as $data) {
                if ($data[3] === 'ATC')
                    continue;
                if ($flight->vatsim_cid === intval($data[1]) && $flight->callsign === $data[0]) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // close the flight.
                $flight->state = 2;
                $flight->save();
            }
        }
    }
}
