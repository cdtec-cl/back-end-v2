<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MeasureGraph;

class Graph extends Model
{
    protected $fillable = [
        'title',
        'description',
        'active',
    ];

    protected $with = ['measureGraphs'];
    public function measureGraphs()
    {
       return $this->hasMany(MeasureGraph::class,'id_graph');
    }
}
