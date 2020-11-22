<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneCalicata extends Model
{
    protected $fillable = [
    	'id_zone',
        'date',
        'comments',
        'image_url',
    ];
}
