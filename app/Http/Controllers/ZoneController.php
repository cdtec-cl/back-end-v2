<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Zone;
use App\ZoneGraph;
use App\Graph;
use App\MeasureGraph;
use App\Farm;
use App\Pump_system;
use App\Measure;
use App\Irrigation;
use App\Hydraulic;
use App\Alarm;
use App\RealIrrigation;
use App\Polygon;
use App\PhysicalConnection;
use App\CloningErrors;
use App\ZoneImages;
use Image;
use File;

class ZoneController extends Controller
{
    protected function requestWiseconn($client,$method,$uri){
        return $client->request($method, $uri, [
            'headers' => [
                'api_key' => '9Ev6ftyEbHhylMoKFaok',
                'Accept'     => 'application/json'
            ]
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'                 => 'required|string|max:45',
            'description'          => 'required|string|max:45',
            'latitude'             => 'required|numeric|max:45',
            'longitude'            => 'required|numeric|max:45',
            'type'                 => 'required',
            'kc'                   => 'required|integer',
            'theoreticalFlow'      => 'required|integer',
            'unitTheoreticalFlow'  => 'required|string|max:45',
            'efficiency'           => 'required|integer',
            'humidityRetention'    => 'required|integer',
            'max'                  => 'required|integer',
            'min'                  => 'required|integer',
            'criticalPoint1'       => 'required|integer',
            'criticalPoint2'       => 'required|integer',
            'id_farm'              => 'required|integer',
            'id_pump_system'       => 'required|integer',
        ],[
            'name.required'                 => 'El name es requerido',
            'name.max'                      => 'El name debe contener como máximo 45 caracteres',
            'description.required'          => 'El description es requerido',
            'description.max'               => 'El description debe contener como máximo 45 caracteres',
            'latitude.required'             => 'El latitude es requerido',
            'latitude.max'                  => 'El latitude debe contener como máximo 45 caracteres',
            'latitude.numeric'              => 'El latitude debe ser un número real',
            'longitude.required'            => 'El longitude es requerido',
            'longitude.max'                 => 'El longitude debe contener como máximo 45 caracteres',
            'longitude.numeric'             => 'El longitude debe ser un número real',
            'type.required'                 => 'El type es requerido',
            'kc.required'                   => 'El kc es requerido',
            'kc.integer'                    => 'El kc debe ser un número entero',
            'theoreticalFlow.required'      => 'El theoreticalFlow es requerido',
            'theoreticalFlow.integer'       => 'El theoreticalFlow debe ser un número entero',
            'unitTheoreticalFlow.required'  => 'El unitTheoreticalFlow es requerido',
            'unitTheoreticalFlow.max'       => 'El unitTheoreticalFlow debe contener como máximo 45 caracteres',
            'efficiency.required'           => 'El efficiency es requiredo',
            'efficiency.integer'            => 'El efficiency debe ser un número entero',
            'humidityRetention.required'    => 'El humidityRetention es requiredo',
            'humidityRetention.integer'     => 'El humidityRetention debe ser un número entero',
            'max.required'                  => 'El max es requiredo',
            'max.integer'                   => 'El max debe ser un número entero',
            'min.required'                  => 'El min es requiredo',
            'min.integer'                   => 'El min debe ser un número entero',
            'criticalPoint1.required'       => 'El criticalPoint1 es requiredo',
            'criticalPoint1.integer'        => 'El criticalPoint1 debe ser un número entero',
            'criticalPoint2.required'       => 'El criticalPoint2 es requiredo',
            'criticalPoint2.integer'        => 'El criticalPoint2 debe ser un número entero',
            'id_farm.required'              => 'El id_farm es requiredo',
            'id_farm.integer'               => 'El id_farm debe ser un número entero',
            'id_pump_system.required'       => 'El id_pump_system es requiredo',
            'id_pump_system.integer'        => 'El id_pump_system debe ser un número entero',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try {
            $farm = Farm::find($request->get('id_farm'));
            $pumpSystem = Pump_system::find($request->get('id_pump_system'));
            $messages=[];
            if(is_null($farm)||is_null($pumpSystem)){
                if(is_null($farm)){
                    array_push($messages,'Campo no existente');
                }
                if(is_null($pumpSystem)){
                    array_push($messages,'Pump System no existente');
                }
                return response()->json(['message'=>$messages],404);
            }
            if($request->get('type')){
                foreach ($request->get('type') as $key => $type) {
                    Type::create([
                        'description'=>$type,
                        'id_zone'=>$newZone->id,
                    ]);
                }
            }
            $element = Zone::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'type' => $request->get('type'),
                'kc' => $request->get('kc'),
                'theoreticalFlow' => $request->get('theoreticalFlow'),
                'unitTheoreticalFlow' => $request->get('unitTheoreticalFlow'),
                'efficiency' => $request->get('efficiency'),
                'humidityRetention' => $request->get('humidityRetention'),
                'max' => $request->get('max'),
                'min' => $request->get('min'),
                'criticalPoint1' => $request->get('criticalPoint1'),
                'criticalPoint2' => $request->get('criticalPoint2'),
                'id_farm' => $request->get('id_farm'),
                'id_pump_system' => $request->get('id_pump_system'),
            ]);
            $response = [
                'message'=> 'Zona registrada satisfactoriamente',
                'data' => $element,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de guardar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function get($id){
        try {            
            $element = Zone::find($id);
            if(is_null($element)){
                return response()->json([
                    'message'=>'Zona no existente',
                    'data'=>$element
                ],404);
            }
            $response = [
                'message'=> 'Zona encontrada satisfactoriamente',
                'data' => $element,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name'                 => 'required|string|max:45',
            'description'          => 'required|string|max:45',
            'latitude'             => 'required|numeric|max:45',
            'longitude'            => 'required|numeric|max:45',
            'type'                 => 'required|string|max:45',
            'kc'                   => 'required|integer',
            'theoreticalFlow'      => 'required|integer',
            'unitTheoreticalFlow'  => 'required|string|max:45',
            'efficiency'           => 'required|integer',
            'humidityRetention'    => 'required|integer',
            'max'                  => 'required|integer',
            'min'                  => 'required|integer',
            'criticalPoint1'       => 'required|integer',
            'criticalPoint2'       => 'required|integer',
            'id_farm'              => 'required|integer',
            'id_pump_system'       => 'required|integer'
        ],[
            'name.required'                 => 'El name es requerido',
            'name.max'                      => 'El name debe contener como máximo 45 caracteres',
            'description.required'          => 'El description es requerido',
            'description.max'               => 'El description debe contener como máximo 45 caracteres',
            'latitude.required'             => 'El latitude es requerido',
            'latitude.max'                  => 'El latitude debe contener como máximo 45 caracteres',
            'latitude.numeric'              => 'El latitude debe ser un número real',
            'longitude.required'            => 'El longitude es requerido',
            'longitude.numeric'             => 'El longitude debe ser un número real',
            'type.required'                 => 'El type es requerido',
            'type.max'                      => 'El type debe contener como máximo 45 caracteres',
            'kc.required'                   => 'El kc es requerido',
            'kc.integer'                    => 'El kc debe ser un número entero',
            'theoreticalFlow.required'      => 'El theoreticalFlow es requerido',
            'theoreticalFlow.integer'       => 'El theoreticalFlow debe ser un número entero',
            'unitTheoreticalFlow.required'  => 'El unitTheoreticalFlow es requerido',
            'unitTheoreticalFlow.max'       => 'El unitTheoreticalFlow debe contener como máximo 45 caracteres',
            'efficiency.required'           => 'El efficiency es requiredo',
            'efficiency.integer'            => 'El efficiency debe ser un número entero',
            'humidityRetention.required'    => 'El humidityRetention es requiredo',
            'humidityRetention.integer'     => 'El humidityRetention debe ser un número entero',
            'max.required'                  => 'El max es requiredo',
            'max.integer'                   => 'El max debe ser un número entero',
            'min.required'                  => 'El min es requiredo',
            'min.integer'                   => 'El min debe ser un número entero',
            'criticalPoint1.required'       => 'El criticalPoint1 es requiredo',
            'criticalPoint1.integer'        => 'El criticalPoint1 debe ser un número entero',
            'criticalPoint2.required'       => 'El criticalPoint2 es requiredo',
            'criticalPoint2.integer'        => 'El criticalPoint2 debe ser un número entero',
            'id_farm.required'              => 'El id_farm es requiredo',
            'id_farm.integer'               => 'El id_farm debe ser un número entero',
            'id_pump_system.required'       => 'El id_pump_system es requiredo',
            'id_pump_system.integer'        => 'El id_pump_system debe ser un número entero',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try{
            $element = Zone::find($id);
            if(is_null($element)){
                return response()->json(['message'=>'Zona no existente'],404);
            }
            $element->fill($request->all());
            $response = [
                'message'=> 'Zona actualizada satisfactoriamente',
                'data' => $element,
            ];
            $element->update();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de guardar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function measures(Request $request,$id){
        try {
            $zone=Zone::find($id);
            $today = Carbon::today();
            if(is_null($zone)){
                return response()->json(['message'=>'Zona no existente'],404);
            }
            $measures = Measure::where("id_zone",$zone->id)->get();
            $wiseconnMeasures=[];
            //forzando no clonar desde controlador por lentitud en tiempo de respuesta 
            //$cloningErrors=CloningErrors::where("elements","/zones/id/measures")->where("uri","/zones/".$zone->id_wiseconn."/measures")->where("id_wiseconn",$zone->id_wiseconn)->get();
            /*if(count($cloningErrors)>0){
                foreach ($cloningErrors as $key => $cloningError) {
                    try{
                        $wiseconnMeasures = json_decode(($this->requestWiseconn(new Client([
                            'base_uri' => 'https://apiv2.wiseconn.com',
                            'timeout'  => 100.0,
                        ]),'GET','/zones/'.$zone->id_wiseconn.'/measures/'))->getBody()->getContents());
                        foreach ($wiseconnMeasures as $key => $wiseconnMeasure) {
                            if(isset($wiseconnMeasure->id)){
                                $measure=Measure::where("id_wiseconn",$wiseconnMeasure->id)->first();
                                $farm=Farm::where("id_wiseconn",$wiseconnMeasure->farmId)->first();
                                if(is_null($measure)){
                                    $measure = Measure::create([
                                        'name' => isset($wiseconnMeasure->name)?$wiseconnMeasure->name:null,
                                        'unit' => isset($wiseconnMeasure->unit)?$wiseconnMeasure->unit:null,
                                        'lastData' => isset($wiseconnMeasure->lastData)?$wiseconnMeasure->lastData:null,
                                        'lastDataDate'=> isset($wiseconnMeasure->lastDataDate)?(Carbon::parse($wiseconnMeasure->lastDataDate)):null,
                                        'monitoringTime' => isset($wiseconnMeasure->monitoringTime)?$wiseconnMeasure->monitoringTime:null,
                                        'sensorType' => isset($wiseconnMeasure->sensorType)?$wiseconnMeasure->sensorType:null,
                                        'id_zone' => isset($zone->id)?$zone->id:null,
                                        'id_farm' => isset($farm->id)?$farm->id:null,
                                        'id_wiseconn' => $wiseconnMeasure->id
                                    ]);
                                    if(isset($wiseconnMeasure->id_physical_connection)){
                                        PhysicalConnection::create([
                                            'expansionPort'=> isset($wiseconnMeasure->physicalConnection)?$wiseconnMeasure->physicalConnection->expansionPort:null,
                                            'expansionBoard'=> isset($wiseconnMeasure->physicalConnection)?$wiseconnMeasure->physicalConnection->expansionBoard:null,
                                            'nodePort'=> isset($wiseconnMeasure->physicalConnection)?$wiseconnMeasure->physicalConnection->nodePort:null
                                        ]);
                                    }
                                    $zone->touch();
                                }
                            }
                        }
                        $cloningError->delete();
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                            'error' => $e->getMessage(),
                            'linea' => $e->getLine()
                        ], 500);
                    }
                }
            }*/
            $response = [
                'message'=> 'Measure encontrado satisfactoriamente',
                'data' => Measure::where("id_zone",$zone->id)->get(),
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function irrigations($id){
        try {            
            $elements = Irrigation::where("id_zone",$id)->with("farm")->with("volume")->with("pumpSystem")->get();
            $response = [
                'message'=> 'Irrigation encontrado satisfactoriamente',
                'data' => $elements,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function hydraulics($id){
        try {            
            $elements = Hydraulic::where("id_zone",$id)->get();
            $response = [
                'message'=> 'Lista de Hydraulic',
                'data' => $elements,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function alarmsTriggered(Request $request,$id){
        try {
            $elements = Alarm::where("id_zone",$id)->whereBetween('date', [$request->get('initTime'), $request->get('endTime')])->get();
            $response = [
                'message'=> 'Lista de Alarm',
                'data' => $elements,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    protected function createRealIrrigation($wiseconnRealIrrigation,$farm,$pumpSystem,$zone){
        return RealIrrigation::create([
            'initTime' => isset($wiseconnRealIrrigation->initTime)?$wiseconnRealIrrigation->initTime:null,
            'endTime' =>isset($wiseconnRealIrrigation->endTime)?$wiseconnRealIrrigation->endTime:null,
            'status'=> isset($wiseconnRealIrrigation->status)?$wiseconnRealIrrigation->status:null,
            'id_farm'=> isset($farm->id)?$farm->id:null,
            'id_pump_system'=> isset($pumpSystem->id)?$pumpSystem->id:null,
            'id_zone'=> isset($zone->id)?$zone->id:null,
            'id_wiseconn' => $wiseconnRealIrrigation->id
        ]);
    }
    public function realIrrigations(Request $request,$id){
        try {
            $zone=Zone::find($id);
            $wiseconnRealIrrigations=[];
            if($zone){
                $farm=$zone->id_farm?Farm::find($zone->id_farm):null;
                $initTime=(Carbon::parse($request->input("initTime")))->format('Y-m-d');
                $endTime=(Carbon::parse($request->input("endTime")))->format('Y-m-d');
                $cloningErrors=CloningErrors::where("elements","/zones/id/realIrrigations")->where("uri",'LIKE',"/zones/".$zone->id_wiseconn."/realIrrigations/%")->where("id_wiseconn",$zone->id_wiseconn)->get();
                    //forzando no clonar desde controlador por lentitud en tiempo de respuesta 
                    /*if(count($cloningErrors)>0){
                        foreach ($cloningErrors as $key => $cloningError) {
                            try{
                                $wiseconnRealIrrigations = json_decode(($this->requestWiseconn(new Client([
                                    'base_uri' => 'https://apiv2.wiseconn.com',
                                    'timeout'  => 100.0,
                                ]),'GET',$cloningError->uri))->getBody()->getContents());
                                foreach ($wiseconnRealIrrigations as $key => $wiseconnRealIrrigation) {
                                    if(isset($wiseconnRealIrrigation->id)){
                                        $realIrrigation=RealIrrigation::where("id_wiseconn",$wiseconnRealIrrigation->id)->first();
                                        if(is_null($realIrrigation)){                                    
                                            $pumpSystem=Pump_system::where("id_wiseconn",$wiseconnRealIrrigation->pumpSystemId)->first();
                                            $realIrrigation= $this->createRealIrrigation($wiseconnRealIrrigation,$farm,$pumpSystem,$zone);
                                        }
                                    }
                                }
                                $cloningError->delete();
                            } catch (\Exception $e) {
                                return response()->json([
                                    'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                                    'error' => $e->getMessage(),
                                    'linea' => $e->getLine()
                                ], 500);
                            }
                        }
                    }*/
                    $wiseconnRealIrrigations=[];
                    //forzando no clonar desde controlador por lentitud en tiempo de respuesta 
                    /*$realIrrigations=RealIrrigation::where("id_zone",$zone->id)
                        ->where("initTime",">=",$initTime)
                        ->where(function ($q) use ($endTime) {
                            $q->where("endTime","<=",$endTime)->orWhere("status", "Running");
                        })->with("pumpSystem")->with("irrigations")->with("farm")->get();*/
                    /*if(count($realIrrigations)>0){
                        try{
                                $wiseconnRealIrrigations = json_decode(($this->requestWiseconn(new Client([
                                    'base_uri' => 'https://apiv2.wiseconn.com',
                                    'timeout'  => 100.0,
                                ]),'GET',"/zones/".$zone->id_wiseconn."/realIrrigations?initTime=".$initTime."&endTime=".$endTime))->getBody()->getContents());
                                foreach ($wiseconnRealIrrigations as $key => $wiseconnRealIrrigation) {
                                    if(isset($wiseconnRealIrrigation->id)){
                                        $realIrrigation=RealIrrigation::where("id_wiseconn",$wiseconnRealIrrigation->id)->first();
                                        if(is_null($realIrrigation)){                                    
                                            $pumpSystem=Pump_system::where("id_wiseconn",$wiseconnRealIrrigation->pumpSystemId)->first();
                                            $realIrrigation= $this->createRealIrrigation($wiseconnRealIrrigation,$farm,$pumpSystem,$zone);
                                        }                             
                                    }
                                }
                            } catch (\Exception $e) {
                                return response()->json([
                                    'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                                    'error' => $e->getMessage(),
                                    'linea' => $e->getLine()
                                ], 500);
                            }
                        }*/
                        $response = [
                            'message'=> 'Lista de RealIrrigation',
                            'zone'=> $zone,
                            'wiseconnRealIrrigations'=>$wiseconnRealIrrigations,
                            'data' => RealIrrigation::where("id_zone",$zone->id)
                            ->where("initTime",">=",$initTime)
                            ->where(function ($q) use ($endTime) {
                                $q->where("endTime","<=",$endTime)->orWhere("status", "Running");
                            })->with("pumpSystem")->with("irrigations")->with("farm")->get()
                        ];
                        return response()->json($response, 200);
                    }else{                
                        return response()->json(['message'=>'Zona no existente'],404);
                    }

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                        'error' => $e->getMessage(),
                        'linea' => $e->getLine()
                    ], 500);
                }
            }
            public function wiseconnMeasures($id){
                try {
                    $zone=Zone::where('id_wiseconn',$id)->first();
                    if(is_null($zone)){
                        $wiseconnMeasures = json_decode(($this->requestWiseconn(new Client([
                            'base_uri' => 'https://apiv2.wiseconn.com',
                            'timeout'  => 100.0,
                        ]),'GET','/zones/'.$id.'/measures/'))->getBody()->getContents());
                        $response = [
                            'message'=> 'Lista de measures de wiseconn api',
                            'data'=> $wiseconnMeasures,
                        ];
                        return response()->json($response, 200);
                    }
                    return response()->json([
                        'message'=>'Zona existente en data local',
                        'data'=>$zone
                    ],200);
                    
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                        'error' => $e->getMessage(),
                        'linea' => $e->getLine()
                    ], 500);
                }
            }
            public function savePhoto($photo){
                $file_ext = $photo->getClientOriginalExtension();
                $filename = '/images/'. time() . '-' .rand(0,100).'.'.$file_ext;
                Image::make($photo)->save(public_path($filename));
                return $filename;
            }
            public function updateAndMeasures(Request $request,$id){
                try {
                    $localZone=Zone::find($id);
                    $apiZone=Zone::where('id_wiseconn',$id)->first();
                    $zone=!is_null($apiZone)?($apiZone):($localZone);
                    $requestZone=json_decode($request->get('zone'));
                    if(is_null($zone)&&!is_null($requestZone)&&!is_null($request->get('id_farm'))){
                        $newZone=new Zone();
                        $newZone->name=$requestZone->name;
                        $newZone->latitude=$requestZone->latitude;
                        $newZone->longitude=$requestZone->longitude;
                        $newZone->id_farm=$request->get('id_farm');
                        $newZone->id_wiseconn=$id;
                        $newZone->surface=isset($requestZone->surface)?$requestZone->surface:null;
                        $newZone->species=isset($requestZone->species)?$requestZone->species:null;
                        $newZone->variety=isset($requestZone->variety)?$requestZone->variety:null;
                        $newZone->plantation_year=isset($requestZone->plantation_year)?$requestZone->plantation_year:null;
                        $newZone->emitter_flow=isset($requestZone->emitter_flow)?:null;
                        $newZone->distance_between_emitters=isset($requestZone->distance_between_emitters)?$requestZone->distance_between_emitters:null;
                        $newZone->plantation_frame=isset($requestZone->plantation_frame)?$requestZone->plantation_frame:null;
                        $newZone->probe_type=isset($requestZone->probe_type)?$requestZone->probe_type:null;
                        $newZone->type_irrigation=isset($requestZone->type_irrigation)?$requestZone->type_irrigation:null;
                        $newZone->weather=isset($requestZone->weather)?$requestZone->weather:null;
                        $newZone->soil_type=isset($requestZone->soil_type)?$requestZone->soil_type:null;
                        $newZone->graph1_url=isset($requestZone->graph1_url)?$requestZone->graph1_url:null;
                        $newZone->graph2_url=isset($requestZone->graph2_url)?$requestZone->graph2_url:null;
                        $newZone->image_url=isset($requestZone->image_url)?$requestZone->image_url:asset('/images/default.jpg');
                        $newZone->title_second_graph=isset($requestZone->title_second_graph)?$requestZone->title_second_graph:null;
                        
                        if(isset($requestZone->graph1_url)||isset($requestZone->graph2_url)){
                            $newZone->floor_cb=true;  
                        }
                        $newZone->installation_date=isset($requestZone->installation_date)?$requestZone->installation_date:null;
                        $newZone->number_roots=isset($requestZone->number_roots)?$requestZone->number_roots:null;
                        $newZone->plant=isset($requestZone->plant)?$requestZone->plant:null;
                        $newZone->probe_plant_distance=isset($requestZone->probe_plant_distance)?$requestZone->probe_plant_distance:null;
                        $newZone->sprinkler_probe_distance=isset($requestZone->sprinkler_probe_distance)?$requestZone->sprinkler_probe_distance:null;
                        $newZone->installation_type=isset($requestZone->installation_type)?$requestZone->installation_type:null;
                        $newZone->save();

                        $requestMeasures=json_decode($request->get('measures'));
                        foreach ($requestMeasures as $key => $value) {
                            $measure=Measure::where("id_wiseconn",$value->id)->first();
                            if(is_null($measure)){
                                $newMeasure= new Measure();
                                $newMeasure->name=$value->name;
                                $newMeasure->id_wiseconn=$value->id;
                                $newMeasure->id_zone=$newZone->id;
                                $newMeasure->save();

                                $newZone->weather_cb=true;
                                $newZone->update();
                            }else{
                                $measure->name=$value->name;
                                $measure->id_wiseconn=$value->id;
                                $measure->id_zone=$newZone->id;
                                $measure->update();
                            }
                        }

                        $requestGraphs=json_decode($request->get('graphs'));
                        foreach ($requestGraphs as $key => $value) {
                            $graph=Graph::find($value->id);
                            if(!is_null($graph)){
                                $graph->title=isset($value->title)?$value->title:null;
                                $graph->description=isset($value->description)?$value->description:null;
                                $graph->active=isset($value->active)&&$value->active=="0"?false:true;
                                $graph->update();
                                foreach ($value->measure_graphs as $key => $measure_graph) {
                                    $measureGraph=MeasureGraph::find($measure_graph->id);
                                    if(!is_null($measureGraph)){
                                        $measureGraph->graph_type=isset($measure_graph->graph_type)?$measure_graph->graph_type:"line";
                                        if(isset($measure_graph->id_measure)){
                                            $measure=Measure::where('id_wiseconn',$measure_graph->id_measure)->first();
                                            if(!is_null($measure)){
                                                $measureGraph->id_measure=$measure->id;
                                            }
                                        }
                                        $measureGraph->update();
                                    }
                                }
                                $zoneGraph=new ZoneGraph();
                                $zoneGraph->id_graph=$graph->id;
                                $zoneGraph->id_zone=$newZone->id;
                                $zoneGraph->save();
                            }
                        }

                        for ($i=0; $i < intval($request->get("zoneImagesCount")); $i++) { 
                            $filename=$this->SavePhoto($request->file("zoneImage".$i));
                            if($filename){
                                $element = ZoneImages::create([
                                    'id_zone' => $newZone->id,
                                    'image' => $filename?asset($filename):asset('/images/default.jpg'),
                                ]);
                            }
                        }
                        $response = [
                            'message'=> 'Registro de zona y measures',
                        ];
                        return response()->json($response, 200);
                    }
                    if(!is_null($zone)){
                        $zone->name=$requestZone->name;
                        $zone->latitude=$requestZone->latitude;
                        $zone->longitude=$requestZone->longitude;
                        $zone->surface=$requestZone->surface;
                        $zone->species=$requestZone->species;
                        $zone->variety=$requestZone->variety;
                        $zone->plantation_year=$requestZone->plantation_year;
                        $zone->emitter_flow=$requestZone->emitter_flow;
                        $zone->distance_between_emitters=$requestZone->distance_between_emitters;
                        $zone->plantation_frame=$requestZone->plantation_frame;
                        $zone->probe_type=$requestZone->probe_type;
                        $zone->type_irrigation=$requestZone->type_irrigation;
                        $zone->weather=$requestZone->weather;
                        $zone->soil_type=$requestZone->soil_type;
                        $zone->graph1_url=isset($requestZone->graph1_url)?$requestZone->graph1_url:$zone->graph1_url;
                        $zone->graph2_url=isset($requestZone->graph2_url)?$requestZone->graph2_url:$zone->graph2_url;
                        $zone->image_url=isset($requestZone->image_url)?$requestZone->image_url:asset('/images/default.jpg');
                        $zone->title_second_graph=isset($requestZone->title_second_graph)?$requestZone->title_second_graph:null;
                        
                        if(isset($requestZone->graph1_url)||isset($requestZone->graph2_url)){
                            $zone->floor_cb=true;  
                        }                    
                        $zone->installation_date=isset($requestZone->installation_date)?$requestZone->installation_date:$zone->installation_date;
                        $zone->number_roots=isset($requestZone->number_roots)?$requestZone->number_roots:$zone->number_roots;
                        $zone->plant=isset($requestZone->plant)?$requestZone->plant:$zone->plant;
                        $zone->probe_plant_distance=isset($requestZone->probe_plant_distance)?$requestZone->probe_plant_distance:$zone->probe_plant_distance;
                        $zone->sprinkler_probe_distance=isset($requestZone->sprinkler_probe_distance)?$requestZone->sprinkler_probe_distance:$zone->sprinkler_probe_distance;
                        $zone->installation_type=isset($requestZone->installation_type)?$requestZone->installation_type:$zone->installation_type;
                        $zone->update();

                        $requestMeasures=json_decode($request->get('measures'));
                        foreach ($requestMeasures as $key => $value) {
                            $measure=Measure::find($value->id);
                            if(!is_null($measure)){
                                $measure->name=$value->name;
                                $measure->id_wiseconn=$value->id;
                                $measure->id_zone=$zone->id;
                                $measure->update();
                            }
                        }

                        $requestGraphs=json_decode($request->get('graphs'));
                        foreach ($requestGraphs as $key => $value) {
                            $graph=Graph::find($value->id);
                            if(!is_null($graph)){
                                $graph->title=isset($value->title)?$value->title:null;
                                $graph->description=isset($value->description)?$value->description:null;
                                $graph->active=isset($value->active)&&$value->active=="0"?false:true;
                                $graph->update();
                                foreach ($value->measure_graphs as $key => $measure_graph) {
                                    $measureGraph=MeasureGraph::find($measure_graph->id);
                                    if(!is_null($measureGraph)){
                                        $measureGraph->graph_type=isset($measure_graph->graph_type)?$measure_graph->graph_type:"line";
                                        $measureGraph->id_measure=isset($measure_graph->id_measure)?$measure_graph->id_measure:$measureGraph->id_measure;
                                        $measureGraph->update();
                                    }
                                }
                            }
                        }
                        for ($i=0; $i < intval($request->get("zoneImagesCount")); $i++) { 
                            $filename=$this->SavePhoto($request->file("zoneImage".$i));
                            if($filename){
                                $element = ZoneImages::create([
                                    'id_zone' => $zone->id,
                                    'image' => $filename?asset($filename):asset('/images/default.jpg'),
                                ]);
                            }
                        }
                    }else{
                        $response = [
                        'message'=> 'Zona no existente',
                        ];
                        return response()->json($response, 404);
                    }

                    $response = [
                        'message'=> 'Registro de zona y measures',
                        'data'=> $request->all(),
                    ];
                    return response()->json($response, 200);

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                        'error' => $e->getMessage(),
                        'linea' => $e->getLine()
                    ], 500);
                }
            }

            public function deleteImage(Request $request,$id){
                try {
                    $zoneImages=ZoneImages::where("id_zone",$id)->where("image",$request->get("url"))->first();
                    if(!is_null($zoneImages)){
                        if(file_exists(public_path("images/".$request->get("filename")))){
                            unlink(public_path("images/".$request->get("filename")));
                        }
                        $zoneImages->delete();
                    }
                    $response = [
                        'message'=> 'Imagen eliminada satisfactoriamente',
                        'id' => $id,
                        'data' => $request->all(),
                    ];
                    return response()->json($response, 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Ha ocurrido un error al tratar de obtener los datos.',
                        'error' => $e->getMessage(),
                        'linea' => $e->getLine()
                    ], 500);
                }
            }

        }
