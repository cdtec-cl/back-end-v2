<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ZoneCoordinatesMap;
class FarmGoogleMapsFile extends Model
{
    protected $fillable = [
        'id_farm',
        'path_file',
    ];

    protected $with = [
        'zonesCoordinatesMap',
    ];
    public function zonesCoordinatesMap(){
        return $this->hasMany(ZoneCoordinatesMap::class,'id_farm_google_maps_file');
    }
}
