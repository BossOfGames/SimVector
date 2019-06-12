<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class FlightData extends Model
{
    protected $guarded = ['_id'];
    // protected $fillable = ['coordinates', 'heading', 'altitude', 'groundspeed'];
}
