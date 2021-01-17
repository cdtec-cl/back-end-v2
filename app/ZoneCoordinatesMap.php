<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneCoordinatesMap extends Model
{
    protected $fillable = [
    	'id_zone',
        'lat',
        'lng',
    ];
}
