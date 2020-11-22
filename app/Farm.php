<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;
use App\Zone;
class Farm extends Model
{
    protected $fillable = [
        'name',
        'description',
        'latitude', 
        'longitude',
        'postalAddress', 
        'timeZone',
        'webhook',
        'id_account',
        'active_cloning',
        'total_area',//superficie total
        'amount_equipment_irrigation',//Cantidad de equipos de Riego
        'number_sectors_irrigation',//Cantidad de sectores de Riego
        'quantity_wells',//cantidad de pozos
        'start_installation',//inicio de instalacion
        'end_installation',//fin de instalacion
        'id_wiseconn'
    ];
  	protected $with = ['account'];
    public function account()
    {
        return $this->hasOne(Account::class,'id','id_account');
    }
    public function zones()
    {       
       return $this->hasMany(Zone::class,'id_farm');
    }
}
