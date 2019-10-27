<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'latitude', 
        'longitude', 
        'kc', 
        'theoretical_flow',
        "unit_theoretical_flow",
        "efficiency",
        "humidity_retention",
        "max",
        "min",
        "critical_point1",
        "critical_point2"
    ];
}
