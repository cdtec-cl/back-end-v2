<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Mail\ZoneAlert as ZoneAlertMail;
use App\Zone;
use App\ZoneAlert;
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
    protected function getAlertMessage($name,$url){
        $apiResponse = $this->requestApi(new Client([
            'base_uri' => $url,
            'timeout'  => 1000.0,
        ]),'GET','')->getBody()->getContents();
        $explodeResult=explode(",", $apiResponse);
        $currentStateHumidity=floatval($explodeResult[0]);
        $saturationZone=floatval($explodeResult[1]);
        $stressZone=floatval($explodeResult[3]);
        //Estrés < suma humedad = hay estrés
        if($currentStateHumidity<$stressZone){
            return "Hay zona de estrés en el sector ".$name;
        }elseif($currentStateHumidity>$saturationZone){
            return "Hay zona de saturación del sector ".$name;
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
                $alertMessage=strpos($zone->image_url,'images/default.jpg')===false?$this->getAlertMessage($zone->name,$zone->image_url):null;
                print_r($alertMessage);
                if(!is_null($alertMessage)){
                    if(count($zoneAlert->mails)>0){
                        print_r($zoneAlert);
                        foreach ($zoneAlert->mails as $key => $mail) {
                            if(is_null($zoneAlert->last_mail_send_date)&&!is_null($mail->mail)){
                                Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                $zoneAlert->last_mail_send_date=Carbon::now();
                                $zoneAlert->update();
                                $this->info("Mail enviado a: ".$mail->mail);
                            }else{
                                $this->info('paso por aca');
                                $datework = is_null($zoneAlert->last_mail_send_date)?(Carbon::now()):Carbon::createFromDate($zoneAlert->last_mail_send_date);
                                $now = Carbon::now();
                                $diffInMinutes = $datework->diffInMinutes($now);
                                $diffInHours = $datework->diffInHours($now);
                                $this->info($zoneAlert->out_range);
                                switch ($zoneAlert->out_range) {
                                    case '5 minutos':
                                        if($diffInMinutes>=5){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '15 minutos':
                                        if($diffInMinutes>=15){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '30 minutos':
                                        if($diffInMinutes>=30){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break; 
                                    case '45 minutos':
                                        if($diffInMinutes>=45){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '1 hora':
                                        if($diffInHours>=1){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '2 horas':
                                        if($diffInHours>=2){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '3 horas':
                                        if($diffInHours>=3){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    case '6 horas':
                                        if($diffInHours>=6){
                                            Mail::to($mail->mail)->send(new ZoneAlertMail($alertMessage));
                                            $this->info("Mail enviado a: ".$mail->mail);
                                        }
                                        break;
                                    default:
                                        $this->info("El valor de 'out_range' no corresponde a los predefinidos");
                                        break;
                                }
                            }  
                        }
                     
                        $zoneAlert->last_mail_send_date=Carbon::now()->toDateTimeString();
                        $zoneAlert->update();
                    }
                }
            }
        }
    }
}
