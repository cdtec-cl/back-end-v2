<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Zone;
use App\Node;
use App\Farm;
use App\PhysicalConnection;
use App\Measure;
use App\MeasureData;
use App\CloningErrors;
class MeasureController extends Controller{    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'                   => 'required|string|max:45',
            'unit'                   => 'required|string|max:45',
            'lastData'               => 'required',
            'lastDataDate'           => 'required',
            'monitoringTime'         => 'required|string|max:45',
            'sensorDepth'            => 'required|string|max:45',
            'depthUnit'              => 'required|string|max:45',
            'sensorType'             => 'required|string|max:45',
            'readType'               => 'required|string|max:45',
            'id_node'                => 'required|integer',
            'id_zone'                => 'required|integer',
            'id_farm'                => 'required|integer',
            'id_physical_connection' => 'required|integer'
        ],[
            'name.required'                   => 'El name es requerido',
            'name.max'                        => 'El name debe contener como máximo 45 caracteres',
            'unit.required'                   => 'El unit es requerido',
            'unit.max'                        => 'El unit debe contener como máximo 45 caracteres',
            'lastData.required'               => 'El lastData es requerido',
            'lastDataDate.required'           => 'El lastDataDate es requerido',
            'monitoringTime.required'         => 'El monitoringTime es requerido',
            'monitoringTime.max'              => 'El monitoringTime debe contener como máximo 45 caracteres',
            'sensorDepth.required'            => 'El sensorDepth es requerido',
            'sensorDepth.max'                 => 'El sensorDepth debe contener como máximo 45 caracteres',
            'depthUnit.required'              => 'El depthUnit es requerido',
            'depthUnit.max'                   => 'El depthUnit debe contener como máximo 45 caracteres',
            'sensorType.required'             => 'El sensorType es requerido',
            'sensorType.max'                  => 'El sensorType debe contener como máximo 45 caracteres',
            'readType.required'               => 'El readType es requerido',
            'readType.max'                    => 'El readType debe contener como máximo 45 caracteres',
            'id_node.required'                => 'El id_node es requerido',
            'id_node.integer'                 => 'El id_node debe ser un número entero',
            'id_zone.required'                => 'El id_zone es requerido',
            'id_zone.integer'                 => 'El id_zone debe ser un número entero',
            'id_farm.required'                => 'El id_farm es requerido',
            'id_farm.integer'                 => 'El id_farm debe ser un número entero',
            'id_physical_connection.required' => 'El id_physical_connection es requerido',
            'id_physical_connection.integer'  => 'El id_physical_connection debe ser un número entero',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try {
            $node = Node::find($request->get('id_node'));
            $zone = Zone::find($request->get('id_zone'));
            $farm = Farm::find($request->get('id_farm'));
            $physicalConnection = PhysicalConnection::find($request->get('id_physical_connection'));
            $messages=[];
            if(is_null($node)||is_null($zone)||is_null($farm)||is_null($physicalConnection)){                
                if(is_null($node)){
                array_push($messages,'Node no existente');
                }
                if(is_null($zone)){
                array_push($messages,'Zona no existente');
                }
                if(is_null($farm)){
                array_push($messages,'Campo no existente');
                }
                if(is_null($physicalConnection)){
                array_push($messages,'Physical Connection no existente');
                }
                return response()->json(["message"=>$messages],404);
            }
            $element = Measure::create([
                'name' => $request->get('name'),
                'unit' => $request->get('unit'),
                'lastData' => $request->get('lastData'),
                'lastDataDate' => $request->get('lastDataDate'),
                'monitoringTime' => $request->get('monitoringTime'),
                'sensorDepth' => $request->get('sensorDepth'),
                'depthUnit' => $request->get('depthUnit'),
                'sensorType' => $request->get('sensorType'),
                'readType' => $request->get('readType'),
                'id_node' => $request->get('id_node'),
                'id_zone' => $request->get('id_zone'),
                'id_farm' => $request->get('id_farm'),
                'id_physical_connection' => $request->get('id_physical_connection')
            ]);
            $response = [
                'message'=> 'Measure registrado satisfactoriamente',
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
            $element = Measure::with("physicalConnection")->find($id);
            if(is_null($element)){
                return response()->json([
                    "message"=>"non-existent item",
                    "data"=>$element
                ],404);
            }
            $response = [
                'message'=> 'item found successfully',
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
    protected function requestWiseconn($client,$method,$uri){
        return $client->request($method, $uri, [
            'headers' => [
                'api_key' => '9Ev6ftyEbHhylMoKFaok',
                'Accept'     => 'application/json'
            ]
        ]);
    }
    protected function measureDataCreate($measure,$measureData){
        return MeasureData::create([
            'id_measure'=> isset($measure->id)?$measure->id:null,
            'value'=> isset($measureData->value)?$measureData->value:null,
            'time'=> isset($measureData->time)?$measureData->time:null
        ]);
    }
    public function data(Request $request,$id){
        $arrays=$request->all();        

        $dataId = array();        
        foreach ($arrays as $key => $array) {            
            $id= substr($key, 0,2);
            if($id==='id') {
                $dataId[]= $array;

            }
        }
        $dataMeasure = array();
       
        $dataResponse2 = array();
        $cont = 0;

           
        foreach($dataId as $key => $value){
            $dataResponse = array();
            $measure=Measure::find($value);
            if(is_null($measure)){
                return response()->json([
                    "message"=>"Measure no existente",
                    "data"=>$measure
                ],404);
            }

            $dataMeasure[]=MeasureData::where("id_measure",$value)
                                       ->whereBetween("time",[$request->input("initTime"),$request->input("endTime")])
                                       ->select(\DB::raw(
                                        
                                        'UNIX_TIMESTAMP(CONVERT_TZ(time, "+00:00", @@global.time_zone)) as date_measure,
                                        value, 
                                        time
                                     '
                                     ))->orderBy('time', 'ASC')->get();
                       
            
            foreach($dataMeasure[$cont] as $value){  
                $dataResponse[] = array(intval(($value->date_measure)*1000),
                round($value->value,2), $value->time);                                     
            }
            $dataResponse2[]= $dataResponse;
            $cont= $cont+1;
            

        }
        try {
            
         
          
            $response = [
                'message'=> 'MeasureData encontrado satisfactoriamente',
                'measure'=>$measure,
                'data' => $dataResponse2,
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
    public function filterData(Request $request){
        try {
            $measure=Measure::where("id_zone",$request->input("zone")["id"])
                    ->where("sensorDepth",$request->input("sensorSelected")["sensorDepth"])
                    ->where("unit",$request->input("sensorSelected")["unit"])
                    ->where("depthUnit",$request->input("sensorSelected")["depthUnit"])->first();
            if(is_null($measure)){
                return response()->json([
                    "message"=>"Measure no existente",
                    "data"=>$measure
                ],404);
            }
            $response = [
                'message'=> 'MeasureData encontrado satisfactoriamente',
                'data' => MeasureData::where("id_measure",$measure->id)->whereBetween("time",[$request->input("initTime"),$request->input("endTime")])->orderBy('time', 'DESC')->get(),
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



      //forzando no clonar desde controlador por lentitud en tiempo de respuesta 
            //$cloningErrors=CloningErrors::where("elements","/measures/id/data")->where("uri","/measures/".$measure->id_wiseconn."/data")->where("id_wiseconn",$measure->id_wiseconn)->get();
            /*if(count($cloningErrors)>0){
                foreach ($cloningErrors as $key => $cloningError) {
                    try{
                        $client = new Client([
                            'base_uri' => 'https://apiv2.wiseconn.com',
                            'timeout'  => 100.0,
                        ]);

                        $measuresResponse = $this->requestWiseconn($client,'GET',$cloningError->uri);
                        $measuresData=json_decode($measuresResponse->getBody()->getContents());
                        foreach ($measuresData as $mDkey => $measureData) {
                            if(is_null(MeasureData::where("id_measure",$measure->id)->where("time",$measureData->time)->first())){
                                $newMeasureData = $this->measureDataCreate($measure,$measureData);
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
            //forzando no clonar desde controlador por lentitud en tiempo de respuesta 
            /*if(count(MeasureData::where("id_measure",$measure->id)->whereBetween("time",[$request->input("initTime"),$request->input("endTime")])->orderBy('time', 'DESC')->get())==0){
                try{
                        $client = new Client([
                            'base_uri' => 'https://apiv2.wiseconn.com',
                            'timeout'  => 100.0,
                        ]);

                        $initTime=(Carbon::parse($request->input("initTime")))->format('Y-m-d');
                        $endTime=(Carbon::parse($request->input("endTime")))->format('Y-m-d');
                        $measuresResponse = $this->requestWiseconn($client,'GET','measures/'.$measure->id_wiseconn.'/data?initTime='.$initTime.'T00:00&endTime='.$endTime);
                        $measuresData=json_decode($measuresResponse->getBody()->getContents());
                        foreach ($measuresData as $mDkey => $measureData) {
                            if(is_null(MeasureData::where("id_measure",$measure->id)->where("time",$measureData->time)->first())){
                                $newMeasureData = $this->measureDataCreate($measure,$measureData);
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
}
