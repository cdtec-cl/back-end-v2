<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Farm;
use App\RealIrrigation;
use App\Zone;
use App\Pump_system;
use App\Volume;
use Carbon\Carbon;
use App\CloningErrors;

class CloneByZoneRealIrrigationVolumes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonebyzone:realirrigations:volumes:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone real irrigations data by zone';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected function requestWiseconn($method,$uri){
        $client = new Client([
            'base_uri' => 'https://apiv2.wiseconn.com',
            'timeout'  => 100.0,
        ]);
        return $client->request($method, $uri, [
            'headers' => [
                'api_key' => '9Ev6ftyEbHhylMoKFaok',
                'Accept'     => 'application/json'
            ]
        ]);
    }
    protected function volumeCreate($realIrrigation){
        return Volume::create([
            'value'=> isset($realIrrigation->volume->value)?$realIrrigation->volume->value:null,
            'unitName'=> isset($realIrrigation->volume->unitName)?$realIrrigation->volume->unitName:null,
            'unitAbrev'=> isset($realIrrigation->volume->unitAbrev)?$realIrrigation->volume->unitAbrev:null
        ]);
    }
    protected function realIrrigationCreate($realIrrigation,$zone,$volume,$pumpSystem){
        return RealIrrigation::create([
            'initTime' => isset($realIrrigation->initTime)?$realIrrigation->initTime:null,
            'endTime' =>isset($realIrrigation->endTime)?$realIrrigation->endTime:null,
            'status'=> isset($realIrrigation->status)?$realIrrigation->status:null,
            'id_pump_system'=> isset($pumpSystem->id)?$pumpSystem->id:null,
            'id_zone'=> isset($zone->id)?$zone->id:null,
            'id_wiseconn' => $realIrrigation->id
        ]); 
    }
    protected function realIrrigationUpdate($realIrrigation,$realIrrigationRegistered,$zone,$pumpSystem){
        $realIrrigationRegistered->initTime=isset($realIrrigation->initTime)?$realIrrigation->initTime:null;
        $realIrrigationRegistered->endTime=isset($realIrrigation->endTime)?$realIrrigation->endTime:null;
        $realIrrigationRegistered->status=isset($realIrrigation->status)?$realIrrigation->status:null;
        $realIrrigationRegistered->id_pump_system=isset($pumpSystem->id)?$pumpSystem->id:null;
        $realIrrigationRegistered->id_zone=isset($zone->id)?($zone->id):null;
        $realIrrigationRegistered->update();
        return $realIrrigationRegistered; 
    }
    protected function cloneBy($realIrrigation,$zone){
        $pumpSystem=Pump_system::where("id_wiseconn",$realIrrigation->pumpSystemId)->first();
        if(is_null($pumpSystem)){
            $realIrrigationRegistered=RealIrrigation::where("id_wiseconn",$realIrrigation->id)->where("id_zone",$zone->id)->first();
            if(is_null($realIrrigationRegistered)){ 
                $newVolume =$this->volumeCreate($realIrrigation);
                $newRealIrrigation =$this->realIrrigationCreate($realIrrigation,$zone,$newVolume,$pumpSystem);
                $zone->touch();
                $this->info("New Volume, id:".$newVolume->id." / New RealIrrigation, id:".$newRealIrrigation->id);
            }else{
                $realIrrigationUpdated =$this->realIrrigationUpdate($realIrrigation,$realIrrigationRegistered,$zone,$pumpSystem);
                $this->info("Real Irrigation updated:".$realIrrigationUpdated->id);
            }   
        }else{
           $this->info("Elemento existente"); 
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $initTime=Carbon::now(date_default_timezone_get())->subDays(10)->format('Y-m-d');
        $endTime=Carbon::now(date_default_timezone_get())->addDays(5)->format('Y-m-d');
        try{
            $zones=Zone::all();
            foreach ($zones as $key => $zone) {
                if($zone->id_wiseconn){
                    $cloningErrors=CloningErrors::where("elements","/zones/id/realIrrigations")->get();
                    if(count($cloningErrors)>0){
                        foreach ($cloningErrors as $key => $cloningError) {
                            $realIrrigationsResponse = $this->requestWiseconn('GET',$cloningError->uri);
                            $realIrrigations=json_decode($realIrrigationsResponse->getBody()->getContents());
                            $this->info("==========Clonando pendientes por error en peticion (".count($realIrrigations)." elementos)");
                            foreach ($realIrrigations as $key => $realIrrigation) {
                                $this->cloneBy($realIrrigation,$zone);
                            }
                            $cloningError->delete();
                        }
                    }else{
                        try{
                            sleep(1);
                            $currentRequestUri='/zones/'.$zone->id_wiseconn.'/realIrrigations/?endTime='.$endTime.'&initTime='.$initTime;
                            $currentRequestElement='/zones/id/realIrrigations';
                            $id_wiseconn=$zone->id_wiseconn;
                            $this->info($zone->id); 
                            $realIrrigationsResponse = $this->requestWiseconn('GET',$currentRequestUri);
                            $realIrrigations=json_decode($realIrrigationsResponse->getBody()->getContents());
                            foreach ($realIrrigations as $key => $realIrrigation) {
                                $this->cloneBy($realIrrigation,$zone);
                            }
                        } catch (\Exception $e) {
                            $this->error("Error:" . $e->getMessage());
                            $this->error("Linea:" . $e->getLine());
                            $this->error("currentRequestUri:" . $currentRequestUri);
                            if(is_null(CloningErrors::where("elements",$currentRequestElement)->where("uri",$currentRequestUri)->where("id_wiseconn",$id_wiseconn)->first())){
                                $cloningError=new CloningErrors();
                                $cloningError->elements=$currentRequestElement;
                                $cloningError->uri=$currentRequestUri;
                                $cloningError->id_wiseconn=$id_wiseconn;
                                $cloningError->save();
                            }
                        }
                    }
                }                               
            }
            $this->info("Success: Clone real irrigations and volumes data by zone");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        }  
    }
}
