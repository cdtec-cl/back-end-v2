<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Farm;
class Account extends Model
{
    protected $fillable = [
        'name', 
        'rut',
        'telefono',
        'adviser_name', 
        'adviser_rut',
        'adviser_telefono',
        'agent_name', 
        'agent_rut',
        'agent_telefono',
        'razonsocial',
        'rutlegal',
        'direccion',
        'email',
        'comentario',
        'habilitar',
        'turn', //giro
        'admin_status',
        'client_type',
        'platform',
        'id_wiseconn',
        'status'
    ];
    public function farms()
   	{
       return $this->hasMany(Farm::class,'id_account');
   	}
}
