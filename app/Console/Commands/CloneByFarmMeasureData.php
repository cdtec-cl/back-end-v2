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
                    // if(count($cloningErrors)>0){
                    //     $this->info("Cloning Error");
                    //     foreach ($cloningErrors as $key => $cloningError) {
                    //         try{
                    //             if($key % 3 == 0){
                    //                 $this->info("sleep(2)");
                    //                 sleep(2);
                    //             }
                    //             $valor= $key % 3;
                    //             $this->info($valor);                  
                    //             $this->info("requestWiseconn()");
                    //             $this->info($cloningError->uri);
                    //             $measuresResponse = $this->requestWiseconn('GET',$cloningError->uri);
                    //             $measures=json_decode($measuresResponse->getBody()->getContents());
                    //             foreach ($measures as $key => $value) {
                    //                 $measure=Measure::where("id_wiseconn",$value->id)->first();
                    //                 if(!is_null($measure)){
                    //                     if($value->id[0].$value->id[1]== "1-"){                                      
                    //                         if(isset($value->lastData)&&!is_null($value->lastData)&&isset($value->lastDataDate)&&!is_null($value->lastDataDate)){
                    //                             $measureData=new MeasureData();
                    //                             $measureData->value=isset($value->lastData)?$value->lastData:null;
                    //                             $measureData->time=isset($value->lastDataDate)?$value->lastDataDate:null;
                    //                             $measureData->id_measure=$measure->id;
                    //                             $measureData->save();
                    //                             $this->info("New MeasureData id:".$measureData->id);
                    //                         }
                    //                     }else{
                    //                         $this->info("Elemento no registrado por id:".$value->id);
                    //                     }
                    //                 }
                    //                 $cloningError->delete();
                    //             }
                    //         }catch (\Exception $e) {
                    //             $this->error("Error:" . $e->getMessage());
                    //             // $error=explode("message", $e->getMessage(), 2); 
                    //             // $this->error("EN ESTA PINGA:" . $error[0]);
                    //             // $this->error("EN ESTA PINGA:" . $error[1]);
                    //             $this->error("Linea:" . $e->getLine());                                
                    //             $this->error("currentRequestUri:" . $cloningError->uri);

                    //         }
                    //     }
                    // }else{
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
                                $measure2222=Measure::where("id_wiseconn",$value->id)->first();
                                if(!is_null($measure2222)){
                                    if($value->id[0].$value->id[1]== "1-"){
                                        $arrayMeasures[] = [
                                            'id_measure' => $measure2222->id, 
                                            'value'      => isset($value->lastData)?$value->lastData:null,
                                            'time'       => isset($value->lastDataDate)?$value->lastDataDate:null,
                                            'created_at' => $fechaData,
                                            'updated_at' => $fechaData
                                        ];
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
                            $this->info('Se ejecuto ');   
                            sleep(2);
                            $this->info($currentRequestUri . "CURRENT");
                            $measuresResponse2 = $this->requestWiseconn('GET',$currentRequestUri);
                            $measures2=json_decode($measuresResponse2->getBody()->getContents());
                            $this->info($measures2 . "MEASURES");
                            $this->info($measuresResponse2 . "MEASURESRESPONSE");
                            $arrayMeasures2 = []; 
                            foreach ($measures2 as $key => $value) {
                                $measure2222=Measure::where("id_wiseconn",$value->id)->first();
                                if(!is_null($measure2222)){
                                    if($value->id[0].$value->id[1]== "1-"){
                                        $arrayMeasures2[] = [
                                            'id_measure' => $measure2222->id, 
                                            'value'      => isset($value->lastData)?$value->lastData:null,
                                            'time'       => isset($value->lastDataDate)?$value->lastDataDate:null,
                                            'created_at' => $fechaData,
                                            'updated_at' => $fechaData
                                        ];
                                    }
                                }

                            }     
                            DB::table('measure_data')->insert($arrayMeasures2);
                            $this->info('Se Agrego la data');
                            $this->info($currentRequestUri);
                           /* if(is_null(CloningErrors::where("elements",$currentRequestElement)->where("uri",$currentRequestUri)->where("id_wiseconn",$id_wiseconn)->first())){
                                $cloningError=new CloningErrors();
                                $cloningError->elements=$currentRequestElement;
                                $cloningError->uri=$currentRequestUri;
                                $cloningError->id_wiseconn=$id_wiseconn;
                                $cloningError->save();
                            }*/
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
