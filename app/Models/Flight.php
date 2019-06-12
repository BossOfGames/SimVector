<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Flight extends Model
{
    protected $connection = 'mongodb';
    public function flight_data() {
        return $this->embedsMany('App\Models\FlightData');
    }
}
