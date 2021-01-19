<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneCoordinatesMap extends Model
{
    protected $fillable = [
    	'id_zone',
        'lat',
        'lng',
        'bookmark_name',
        'id_farm_google_maps_file'
    ];
}
