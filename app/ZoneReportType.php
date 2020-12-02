<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneReportType extends Model
{
    protected $fillable = [
    	'id_zone',
        'type',
        'download_url',
    ];
}
