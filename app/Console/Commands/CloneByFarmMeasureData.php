<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\CloningErrors;
use App\Farm;
use App\Measure;
use App\MeasureData;
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
        //
        try{
            $farms=Farm::where('active_cloning',1)->get();
            foreach ($farms as $key => $farm) {
                try{
                    $cloningErrors=CloningErrors::where("elements","/farms/id/measures")->get();
                    $currentRequestUri='/farms/'.$farm->id_wiseconn.'/measures';
                    $currentRequestElement='/farms/id/measures';
                    $id_wiseconn=$farm->id_wiseconn;
                    if(count($cloningErrors)>0){
                        foreach ($cloningErrors as $key => $cloningError) {
                            if($key % 3 == 0){
                                $this->info("sleep(1)");
                                sleep(1);
                            }
                            $this->info("requestWiseconn()");
                            $measuresResponse = $this->requestWiseconn('GET',$cloningError->uri);
                            $measures=json_decode($measuresResponse->getBody()->getContents());
                            foreach ($measures as $key => $value) {
                                $measure=Measure::where("id_wiseconn",$value->id)->first();
                                if(!is_null($measure)){
                                    if($value->id[0].$value->id[1]== "1-"){                                      
                                        if(isset($value->lastData)&&!is_null($value->lastData)&&isset($value->lastDataDate)&&!is_null($value->lastDataDate)){
                                            $measureData=new MeasureData();
                                            $measureData->value=isset($value->lastData)?$value->lastData:null;
                                            $measureData->time=isset($value->lastDataDate)?$value->lastDataDate:null;
                                            $measureData->id_measure=$measure->id;
                                            $measureData->save();
                                            $this->info("New MeasureData id:".$measureData->id);
                                        }
                                    }else{
                                        $this->info("Elemento no registrado por id:".$value->id);
                                    }
                                }
                                $cloningError->delete();
                            }
                        }
                    }else{
                        try{
                            if($key % 3 == 0){
                                $this->info("sleep(1)");
                                sleep(1);
                            }
                            $this->info("requestWiseconn()");
                            $measuresResponse = $this->requestWiseconn('GET',$currentRequestUri);
                            $measures=json_decode($measuresResponse->getBody()->getContents());

                            foreach ($measures as $key => $value) {
                                $measure=Measure::where("id_wiseconn",$value->id)->first();
                                if(!is_null($measure)){
                                    if($value->id[0].$value->id[1]== "1-"){
                                        $measureData=new MeasureData();
                                        $measureData->value=isset($value->lastData)?$value->lastData:null;
                                        $measureData->time=isset($value->lastDataDate)?$value->lastDataDate:null;
                                        $measureData->id_measure=$measure->id;
                                        $measureData->save();
                                        $this->info("New MeasureData id:".$measureData->id);
                                    }else{
                                        $this->info("Elemento no registrado por id:".$value->id);
                                    }
                                }
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
            $this->info("Success: Clone measures data by farm");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        } 
    }
}
