<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Frequency extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'frequencies';
}
