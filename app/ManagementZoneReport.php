<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementZoneReport extends Model
{
    protected $fillable = [
        'id_zone',
        'farm_name',
        'account_name',
        'account_email',
        'account_telefono',
        'poscosecha_2019',
        'caida_de_hoja',
        'brotacion',
        'cuaja',
        'maduracion',
        'tecnica_y_administracion',
        'first_general_remarks',
        'graph1_url',
        'second_general_remarks',
        'kc_sonda',
        'huella_agua',
        'tecnica_administracion',
        'estacion_de_clima',
        'equipo_de_riego',
        'raices',
        'third_general_remarks',
        'download_url'
    ];
    protected $with = ['zone'];
    public function zone()
    {
        return $this->hasOne(Zone::class,'id','id_zone');
    }
}