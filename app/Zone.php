<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Farm;
use App\Type;
use App\SouthWestBound;
use App\NorthEastBound;
use App\Measure;
use App\ZoneGraph;
use App\ZoneImages;
use App\ZoneCalicata;
use App\Graph;
class Zone extends Model
{
    protected $fillable = [
        'name', 'description','latitude', 
        'longitude', 'kc','theoreticalFlow',
        'unitTheoreticalFlow','efficiency',
        'humidityRetention','max','min','criticalPoint1','criticalPoint2',
        'id_farm','id_pump_system','id_wiseconn',
        'graph1_url',
        'graph2_url',
        'surface',//superficie
        'species',//especie
        'variety',//variedad
        'plantation_year',//año de plantación
        'emitter_flow',//caudal del emisor
        'distance_between_emitters',//distancia entre emisores
        'plantation_frame',//marco de plantacion
        'probe_type',//tipo de sonda
        'type_irrigation',//tipo de riego
        'weather',//clima
        'soil_type',//tipo de suelo
        'weather_cb', //radiobutton de clima
        'floor_cb', //radiobutton de clima
        'installation_date', //fecha de instalación
        'number_roots', //cantidad de raices
        'plant', //planta
        'probe_plant_distance', //distancia planta sonda
        'sprinkler_probe_distance', //distancia sonda aspersor
        'installation_type', //tipo de instalacion
        'image_url',
        'title_second_graph',
        'origen',
        'initTime',
        'endTime',
        'progress'
    ];
    protected $with = [
        'path',
        'southWest',
        'northEast',
        'type',
        'measures',
        'zoneGraphs',
        'zoneImages',
        'zoneAlert',
        'zoneCalicata',
        'zoneReport',
        'graphs'
    ];
    protected $hidden   = [
        'id_zone',
        'id_bound',
        'created_at',
        'updated_at',
    ];
    public function farm()
    {
        return $this->hasOne(Farm::class,'id','id_farm');
    }
    public function path()
    {
        return $this->hasMany(Path::class,'id_zone');
    }
    public function southWest() {
        return $this->hasOne(SouthWestBound::class,'id_zone','id');
    }
    public function northEast() {
        return $this->hasOne(NorthEastBound::class,'id_zone','id');
    }
    public function type()
    {
        return $this->hasMany(Type::class,'id_zone');
    }
    public function measures()
    {
        return $this->hasMany(Measure::class,'id_zone');
    }
    public function zoneGraphs()
    {
        return $this->hasMany(ZoneGraph::class,'id_zone');
    }
    public function zoneImages(){
        return $this->hasMany(ZoneImages::class,'id_zone');        
    }
    public function zoneAlert() {
        return $this->hasOne(ZoneAlert::class,'id_zone','id');
    }
    public function zoneCalicata(){
        return $this->hasMany(ZoneCalicata::class,'id_zone');        
    }
    public function zoneReport() {
        return $this->hasOne(ZoneReport::class,'id_zone','id');
    }
    public function graphs()
    {
        return $this->hasMany(Graph::class,'id_zone');
    }
}
