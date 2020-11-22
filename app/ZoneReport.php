<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneReport extends Model
{
    protected $fillable = [
    	'id_zone',
        'probe_name', //nombre de sonda
        'surface', //superficie
        'species', //especie
        'variety', //variedad
        'planting_year', //año de platacion
        'emitter_flow', //caudal del emisor
        'distance_between_emitters', //distancia entre emisores
        'plantation_frame', //marco de plantacion
        'probe_type', //tipo de sondan
        'type_irrigation', //tipo de riego
        'weather', //clima
        'soil_type', //tipo de suelo
    ];
}
