<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Zone;
use App\Measure;
use App\MeasureData;
use App\CloningErrors;
class CloneByMeasureData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonebymeasure:data:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone data by measure';

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
    protected function measureDataCreate($measure,$measureData){
        $measure->lastMeasureDataUpdate=$measureData->time;
        $measure->update();
        return MeasureData::create([
            'id_measure'=> isset($measure->id)?$measure->id:null,
            'value'=> isset($measureData->value)?$measureData->value:null,
            'time'=> isset($measureData->time)?$measureData->time:null
        ]);
    }
    protected function cloneBy($measure,$measureData,$measuresDataCount){
        print_r(MeasureData::where("id_measure",$measure->id)->where("time",$measureData->time)->first());
        if(is_null(MeasureData::where("id_measure",$measure->id)->where("time",$measureData->time)->first())){
            $newMeasureData = $this->measureDataCreate($measure,$measureData);
            $this->info("New MeasureData id:".$newMeasureData->id." cantidad de MeasureData:".$measuresDataCount);
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
        try{
            //$zonesId=Zone::whereIn("name",["Estación Meteorológica","Estación Metereológica"])->pluck("id");
            //$measures=Measure::whereIn("id_zone",$zonesId)->get();
            $measures=Measure::distinct('id_wiseconn')->where('status','=', '1')->get();//all();            
            //desarrollo
           // $measures=Measure::whereIn('id', [52, 198,58,276,59,53])->get(); //all();
           //producci{on}
          // $measures=Measure::whereIn('id', [59,60,61,62,63,64,65,66,67,68,69,70,71,343,344,339,429])->get(); //all();

            $initTime=Carbon::now(date_default_timezone_get())->subDays(20)->format('Y-m-d');
            $endTime=Carbon::now(date_default_timezone_get())->addDays(1)->format('Y-m-d');
            $this->info("==========Fecha Inicio (".$initTime." elementos)");
            $this->info("==========Fecha Finalizacion (".$endTime." elementos)");
            
            
            foreach ($measures as $mKey => $measure) {
                try{
                    $cloningErrors=CloningErrors::where("elements","/measures/id/data")->get();
                    if(count($cloningErrors)>0){
                        foreach ($cloningErrors as $mKey => $cloningError) {
                            $measuresResponse = $this->requestWiseconn('GET',$cloningError->uri);
                            $measuresData=json_decode($measuresResponse->getBody()->getContents());
                            $this->info("==========Clonando pendientes por error en peticion (".count($measuresData)." elementos)");
                            foreach ($measuresData as $mDkey => $measureData) {
                                $this->cloneBy($measure,$measureData,count($measuresData));
                            }
                            $cloningError->delete();
                        }
                    }else{
                        try {
                            /*if($measure->lastMeasureDataUpdate){
                                $initTime=Carbon::parse($measure->lastMeasureDataUpdate)->format('Y-m-d');
                            }*/
                            $this->info("==========INIT TIME (".$initTime." )");
                            $this->info("==========ID MEASURE WISECON (".$measure->id_wiseconn." )");
                            $currentRequestUri='/measures/'.$measure->id_wiseconn.'/data?initTime='.$initTime.'T00:00&endTime='.$endTime.'T00:00';
                            $this->info("==========URL (".$currentRequestUri." )");                          
                            $currentRequestElement='/measures/id/data';
                            $id_wiseconn=$measure->id_wiseconn;
                            $measuresResponse = $this->requestWiseconn('GET',$currentRequestUri);
                            $measuresData=json_decode($measuresResponse->getBody()->getContents());
                            $this->info("==========Clonando nuevos elementos (".count($measuresData)." elementos)");
                            foreach ($measuresData as $mDkey => $measureData) {
                                $this->cloneBy($measure,$measureData,count($measuresData));
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
                } catch (\Exception $e) {
                    $this->error("Error:" . $e->getMessage());
                    $this->error("Linea:" . $e->getLine());
                } 
            }
            $this->info("Success: Clone measures data by node");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        } 
    }
}
