<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallationZoneReport extends Model
{
    protected $fillable = [
        'id_zone',
        'zone_name',
        'farm_name',
        'account_name',
        'account_email',
        'account_telefono',
        'general_detail',
        'species',
        'variety',
        'HA_surface',
        'planting_year',
        'soil_monitoring',
        'irrigation_system',
        'system_precipitation',
        'distance_between_emitters',
        'sector_plantation_frame',
        'plant',
        'plant_probe_distance',
        'probe_dropper_distance',
        'zone_plantation_frame',
        'type_installation',
        'general_remarks',
        'download_url'
    ];
    protected $with = ['zone'];
    public function zone()
    {
        return $this->hasOne(Zone::class,'id','id_zone');
    }
}