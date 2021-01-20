<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zone;
class ZoneCoordinatesMap extends Model
{
    protected $fillable = [
    	'id_zone',
        'lat',
        'lng',
        'bookmark_name',
        'id_farm_google_maps_file'
    ];
    protected $with = ['zone'];
    public function zone()
    {
        return $this->hasOne(Zone::class,'id','id_zone');
    }
}
