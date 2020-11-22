<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneAlertMail extends Model
{
    protected $fillable = [
        'id_zone_alert',
        'mail',
    ]; 
}
