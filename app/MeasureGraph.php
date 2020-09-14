<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasureGraph extends Model
{
    //
    protected $fillable = [
    	'graph_type',
    	'id_graph',
        'id_measure',
    ];
    protected $with = ['measure'];
    public function measure()
    {
        return $this->hasOne(Measure::class,'id','id_measure');
    }
}
