<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Zone;
use App\MeasuresDataTemp;
use App\Measure;
use App\CloningErrors;
class CloneMeasuresDataTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonemeasuresdatatemp:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obteniendo data desde wisecon';

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
        try{
            $zones=Zone::all();
            foreach ($zones as $key => $zone) {
                if($zone->id_wiseconn){
                    try {
                        $currentRequestUri='/zones/'.$zone->id_wiseconn.'/measures/';
                        $currentRequestElement='/zones/id/measures';
                        $measuresResponse = $this->requestWiseconn('GET','/zones/'.$zone->id_wiseconn.'/measures/');
                        $id_wiseconn=$zone->id_wiseconn;
                        $measures=json_decode($measuresResponse->getBody()->getContents());
                        foreach ($measures as $key => $value) {
                            $measure=Measure::where("id_wiseconn",$value->id)->first();
                            if(!is_null($measure)){
                                $measuresDataTemp=new MeasuresDataTemp();
                                $measuresDataTemp->value=isset($value->lastData)?$value->lastData:null;
                                $measuresDataTemp->time=isset($value->lastDataDate)?$value->lastDataDate:null;
                                $measuresDataTemp->id_measure=$measure->id;
                                $measuresDataTemp->save();
                                $this->info("MeasuresDataTemp registrado, id:".$measuresDataTemp->id);
                            }
                        }
                        $this->info("==========Measures retornado (".count($measures)." elementos)");

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
            $this->info("Success: Clone real irrigations and volumes data by zone");
        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
            $this->error("Linea:" . $e->getLine());
        }
    }
}
