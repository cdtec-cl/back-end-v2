<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasuresDataTemp extends Model
{
    protected $fillable = [
        'value','time','id_measure'
    ];
}
