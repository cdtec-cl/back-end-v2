<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ZoneAlertMail;
class ZoneAlert extends Model
{
    protected $fillable = [
        'id_zone',
        'min_value',
        'max_value',
        'out_range',
        'enabled',
        'last_mail_send_date',
        'type'
    ];
    protected $with = [
        'mails',
    ];
    public function mails(){
        return $this->hasMany(ZoneAlertMail::class,'id_zone_alert');
    }
}
