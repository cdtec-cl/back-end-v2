<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Farm;
use App\Node;
use App\Zone;
use App\Measure;
use App\PhysicalConnection;
use App\SensorType;
use App\SensorTypeZones;

class CloneByNodeMeasures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonebynode:measures:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone measures by node';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected function requestWiseconn($client,$method,$uri){
        return $client->request($method, $uri, [
            'headers' => [
                'api_key' => '9Ev6ftyEbHhylMoKFaok',
                'Accept'     => 'application/json'
            ]
        ]);
    }
    protected function physicalConnectionCreate($measure){
        return PhysicalConnection::create([
            'expansionPort'=> isset($measure->physicalConnection)?$measure->physicalConnection->expansionPort:null,
            'expansionBoard'=> isset($measure->physicalConnection)?$measure->physicalConnection->expansionBoard:null,
            'nodePort'=> isset($measure->physicalConnection)?$measure->physicalConnection->nodePort:null
        ]);
    }
    protected function sensorTypeZoneCreate($sensorType,$zone){
        $sensorTypeZone=SensorTypeZones::where("id_sensor_type",$sensorType->id)->where("id_zone",$zone->id)->first();
        if(is_null($sensorTypeZone)){
            SensorTypeZones::create([
                "id_sensor_type"=>$sensorType->id,
                "id_zone" => isset($zone->id)?$zone->id:null,
            ]);
        }        
    }
    protected function sensorTypeCreate($measure,$farm,$zone){
        $sensorType=SensorType::where("name",$measure->sensorType)->first();
        if(is_null($sensorType)){
            $newSensorType=SensorType::create([
                "name"=>$measure->sensorType,
                "id_farm" => isset($farm->id)?$farm->id:null,
            ]);
            $this->sensorTypeZoneCreate($newSensorType,$zone);
            return $newSensorType;
        }else{
            $this->sensorTypeZoneCreate($sensorType,$zone);
        }
        return null;
    }
    protected function measureCreate($measure,$farm,$zone,$node,$newPhysicalConnection){
        return Measure::create([
            'name' => $measure->name,
            'unit' => isset($measure->unit)?$measure->unit:null,
            'lastData' =>isset($measure->lastData)?$measure->lastData:null,
            'lastDataDate'=> isset($measure->lastDataDate)?(Carbon::parse($measure->lastDataDate)):null,
            'monitoringTime'=> isset($measure->monitoringTime)?$measure->monitoringTime:null,
            'sensorDepth' => isset($measure->sensorDepth)?$measure->sensorDepth:null,
            'depthUnit'=> isset($measure->depthUnit)?$measure->depthUnit:null,
            'sensorType'=> isset($measure->sensorType)?$measure->sensorType:null,
            'readType'=> isset($measure->readType)?$measure->readType:null,
            'id_farm' => isset($farm->id)?$farm->id:null,
            'id_zone' => isset($zone->id)?$zone->id:null,
            'id_physical_connection' => isset($newPhysicalConnection->id)?$newPhysicalConnection->id:null,
            'id_wiseconn' => $measure->id
        ]); 
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => 'https://apiv2.wiseconn.com',
            'timeout'  => 100.0,
        ]);
        try{
            $nodes=Node::all();
            foreach ($nodes as $key => $node) {
                $measuresResponse = $this->requestWiseconn($client,'GET','/nodes/'.$node->id_wiseconn.'/measures');
                $measures=json_decode($measuresResponse->getBody()->getContents());
                foreach ($measures as $key => $measure) {
                    if(is_null(Measure::where("id_wiseconn",$measure->id)->first())){
                        $newPhysicalConnection =$this->physicalConnectionCreate($measure);
                        if(isset($measure->farmId)&&isset($measure->zoneId)){
                            $farm=Farm::where("id_wiseconn",$measure->farmId)->first();
                            $zone=Zone::where("id_wiseconn",$measure->zoneId)->first(); 
                            if($measure->farmId==$farm->id_wiseconn&&!is_null($farm)&&!is_null($zone)){ 
                                $newmeasure =$this->measureCreate($measure,$farm,$zone,$newPhysicalConnection); 
                                if(isset($measure->sensorType)){
                                    $newSensorType=$this->sensorTypeCreate($measure,$farm,$zone);
                                    if(!is_null($newSensorType)){
                                        $this->info("New SensorType id:".$newSensorType->id);
                                    }
                                }
                                $this->info("New PhysicalConnectio id:".$newPhysicalConnection->id." / New Measure, id:".$newmeasure->id);
                            }
                        }else{
                            $newmeasure =$this->measureCreate($measure,$farm,null,$newPhysicalConnection); 
                            $this->info("New PhysicalConnectio, id:".$newPhysicalConnection->id." / New Measure, id:".$newmeasure->id);
                        }
                        
                    }  
                }
            }
            $this->info("Success: Clone measures data by node");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        } 
    }
}
