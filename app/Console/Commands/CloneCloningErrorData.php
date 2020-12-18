<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Measure;
use App\CloningErrors;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CloneCloningError extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clonecloningerrorData:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clonando datos desde los errores';

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
            $clonigError=CloningErrors::all();
            $fechaData = Carbon::now();
            foreach ($clonigError as $key => $cloning) {
                if($cloning->elements){
                    try {
                        $currentRequestUri=$cloning->uri;
                        $this->info($currentRequestUri); 
                        $measuresResponse = $this->requestWiseconn('GET',$currentRequestUri);
                        $measures=json_decode($measuresResponse->getBody()->getContents());
                        // $this->info($measures); 
                        $arrayMeasures = []; 
                        foreach ($measures as $key => $value) {
                            $measure=Measure::where("id_wiseconn",$value->id)->first();
                            if(!is_null($measure)){
                                if($value->id[0].$value->id[1]== "1-"){
                                    $arrayMeasures[] = [
                                        'id_measure' => $measure->id, 
                                        'value'      => isset($value->lastData)?$value->lastData:null,
                                        'time'       => isset($value->lastDataDate)?$value->lastDataDate:null,
                                        'created_at' => $fechaData,
                                        'updated_at' => $fechaData
                                    ];
                                }
                            }

                        }     
                        DB::table('measure_data')->insert($arrayMeasures);
                       
                        $cloning->delete();
                        sleep(1);

                    } catch (\Exception $e) {
                        $this->error("Error:" . $e->getMessage());
                        $this->error("Linea:" . $e->getLine());
                        $this->error("currentRequestUri:" . $currentRequestUri);
                        sleep(1);
                       /* if(is_null(CloningErrors::where("elements",$currentRequestElement)->where("uri",$currentRequestUri)->where("id_wiseconn",$id_wiseconn)->first())){
                            $cloningError=new CloningErrors();
                            $cloningError->elements=$currentRequestElement;
                            $cloningError->uri=$currentRequestUri;
                            $cloningError->id_wiseconn=$id_wiseconn;
                            $cloningError->save();
                        }*/
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
