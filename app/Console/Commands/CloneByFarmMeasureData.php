<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\CloningErrors;
use App\Farm;
use App\Measure;
use App\MeasureData;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CloneByFarmMeasureData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonebyfarm:measuresdata:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone measures data by farm';

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
        $fechaDataInicio = Carbon::now();

        //
        try{
            $i=0;
            $farms=Farm::where('active_cloning',1)->get();
            $fechaData = Carbon::now();
            foreach ($farms as $key => $farm) {
                $currentRequestUri='/farms/'.$farm->id_wiseconn.'/measures';
                try{
                    $i=$i+1;
                    $cloningErrors=CloningErrors::where("elements","/farms/id/measures")->get();
                    $currentRequestElement='/farms/id/measures';
                    $id_wiseconn=$farm->id_wiseconn;
                        try{
                            if($key % 3 == 0){
                                sleep(1);
                            }
                            $executionStartTime = microtime(true);
                            $measuresResponse = $this->requestWiseconn('GET',$currentRequestUri);
                            $measures=json_decode($measuresResponse->getBody()->getContents());
                            $executionEndTime = microtime(true);
                            $seconds = $executionEndTime - $executionStartTime;   
                            $this->info($seconds);                       
                            $executionStartTime2 = microtime(true);
                            $arrayMeasures = []; 
                            foreach ($measures as $key => $value) {
                                if($value->id[0].$value->id[1]== "1-" || $value->id[0].$value->id[1]== "3-" || $value->id[0].$value->id[1]== "6-"){
                                    $measure=Measure::where("id_wiseconn",$value->id)->first();
                                    if(!is_null($measure)){
                                        $arrayMeasures[] = [
                                            'id_measure' => $measure->id,
                                            'value'      => isset($value->lastData)?$value->lastData:0,
                                            'time'       => isset($value->lastDataDate)?$value->lastDataDate:null,
                                            'created_at' => $fechaData,
                                            'updated_at' => $fechaData
                                        ]; 
                                        $measure->lastDataDate=$value->lastDataDate;
                                        $measure->update(); 
                                    }
                                }

                            }    
                            DB::table('measure_data')->insert($arrayMeasures);
                            $executionEndTime2 = microtime(true);
                            $seconds2 = $executionEndTime2 - $executionStartTime2;
                            $this->info($seconds2);
                            $this->info($i);
                        } catch (\Exception $e) {
                            $this->error("Error:" . $e->getMessage());
                            $this->error("Linea:" . $e->getLine());
                            $this->error("currentRequestUri:" . $currentRequestUri);
                            $this->info('Se ejecuto');                         
                            $this->info($currentRequestUri);
                            if(is_null(CloningErrors::where("elements",$currentRequestElement)->where("uri",$currentRequestUri)->where("id_wiseconn",$id_wiseconn)->first())){
                                $cloningError=new CloningErrors();
                                $cloningError->elements=$currentRequestElement;
                                $cloningError->uri=$currentRequestUri;
                                $cloningError->id_wiseconn=$id_wiseconn;
                                $cloningError->save();
                            }
                            sleep(2);
                        }
                    // }
                } catch (\Exception $e) {
                    $this->error("Error:" . $e->getMessage());
                    $this->error("Linea:" . $e->getLine());
                    $this->info('Se Agrego la data22222');
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
            // $this->info("Success: Clone measures data by farm");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        } 

        $fechaDataFin = Carbon::now();
        $this->info($fechaDataInicio);
        $this->info($fechaDataFin);
    }
}
