<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DerivedVariables extends Model
{
    protected $fillable = [
        'name','execution_period','variable_start_date','id_zone'
    ];
}
