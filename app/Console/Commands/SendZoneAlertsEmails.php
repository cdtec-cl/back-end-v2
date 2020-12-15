<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Mail\ZoneAlert as ZoneAlertMail;
use App\Zone;
use App\ZoneAlert;
use App\Measure;
class SendZoneAlertsEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendzonealertsemails:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correo de alertas de zona';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected function requestApi($client,$method,$uri){
        return $client->request($method, $uri, [
            'headers' => [
                'Accept'     => 'application/json'
            ]
        ]);
    }
    protected function getAlertMessage($zone,$zoneAlert){
        $name=$zone->name;
        $url=$zone->image_url;
        $type=$zoneAlert->type;
        switch ($type) {
            case 'api':
                $apiResponse = $this->requestApi(new Client([
                    'base_uri' => $url,
                    'timeout'  => 1000.0,
                ]),'GET','')->getBody()->getContents();
                $explodeResult=explode(",", $apiResponse);
                $currentStateHumidity=floatval($explodeResult[0]);
                $saturationZone=floatval($explodeResult[1]);
                $stressZone=floatval($explodeResult[3]);
                //Estrés < suma humedad = 'hay estrés'
                if($currentStateHumidity<$stressZone){
                    return [
                        "title"=>"Zona de riego", 
                        "content"=>"La humedad de la sonda ".$name." se encuentra por debajo de la humedad definida para riego."
                    ];
                }elseif($currentStateHumidity>$saturationZone){
                    return [
                        "title"=>"Máxima humedad", 
                        "content"=>"La humedad de la sonda ".$name.", tiempo de riego excesivo según parámetro de máxima humedad definida."
                    ];
                }
                break;
            case 'local':
                $min_value=$zoneAlert->min_value;
                $max_value=$zoneAlert->max_value;
                $measure=Measure::where('sensorType','Temperature')->where('id_zone',$zone->id)->orderBy('created_at', 'asc')->first();
                if(!is_null($measure)){
                    //valor minimo < valor actual temperatura = 'Existe temperatura alta en '
                    if($min_value<$measure->lastData){
                        return [
                            "title"=>"Temperatura alta", 
                            "content"=>"Existe temperatura alta en ".$name
                        ];
                    }elseif($max_value>$measure->lastData){
                        return [
                            "title"=>"Temperatura baja", 
                            "content"=>"Existe temperatura baja en ".$name
                        ];
                    }   
                }
                return [
                    "title"=>null, 
                    "content"=>null
                ];
                break;
            default:
                # code...
                break;
        }
        
        return null;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $zoneAlerts=ZoneAlert::all();
        foreach ($zoneAlerts as $key => $zoneAlert) {
            if($zoneAlert->enabled==1){//habilitado
                $zone=Zone::find($zoneAlert->id_zone);
                $alertMessage=strpos($zone->image_url,'images/default.jpg')===false?$this->getAlertMessage($zone,$zoneAlert):['title'=>null,'content'=>null];
                if(!is_null($alertMessage['title'])&&!is_null($alertMessage['content'])){
                    if(count($zoneAlert->mails)>0){
                        foreach ($zoneAlert->mails as $key => $mail) {
                            if(is_null($zoneAlert->last_mail_send_date)&&!is_null($mail->mail)){
                                Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                $zoneAlert->last_mail_send_date=Carbon::now();
                                $zoneAlert->update();
                                $this->info("Mail enviado a: ".$mail->mail);
                            }else{
                                $datework = is_null($zoneAlert->last_mail_send_date)?(Carbon::now()):Carbon::createFromDate($zoneAlert->last_mail_send_date);
                                $now = Carbon::now();
                                $diffInMinutes = $datework->diffInMinutes($now);
                                $diffInHours = $datework->diffInHours($now);
                                
                                switch ($zoneAlert->out_range) {
                                    case '5 minutos':
                                        if($diffInMinutes>=5){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '15 minutos':
                                        if($diffInMinutes>=15){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '30 minutos':
                                        if($diffInMinutes>=30){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break; 
                                    case '45 minutos':
                                        if($diffInMinutes>=45){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '1 hora':
                                        if($diffInHours>=1){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '2 horas':
                                        if($diffInHours>=2){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '3 horas':
                                        if($diffInHours>=3){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '6 horas':
                                        if($diffInHours>=6){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '12 horas':
                                        if($diffInHours>=12){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    case '24 horas':
                                        if($diffInHours>=24){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                            $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                                            $zoneAlert->update();
                                        }
                                        break;
                                    default:
                                        $this->info("El valor de 'out_range' no corresponde a los predefinidos");
                                        break;
                                }
                            }  
                        }
                     
                 
                    }
                }
            }
        }
    }
}
