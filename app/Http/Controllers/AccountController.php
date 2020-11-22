<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Account;
use App\Farm;
class AccountController extends Controller
{
    public function all(){
        try {
            $response = [
                'message'=> 'Lista de cuentas',
                'data' => Account::with("farms")->get(),
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
    public function get($id){
        try {            
            $account = Account::find($id);
            if(is_null($account)){
                return response()->json([
                    'message'=>'Cuenta no existente',
                    'data'=>$account
                ],404);
            }
            $response = [
                'message'=> 'Cuenta encontrada',
                'data' => $account,
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
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:45',
            'rut'             => 'required|string|max:45',
            'razonsocial'     => 'required|string|max:45',
            'rutlegal'        => 'max:45',
            'direccion'       => 'required|string|max:45',
            'telefono'        => 'required|string|max:45',
            'email'           => 'required|string|max:45',
            'comentario'      => 'max:45',
            'habilitar'       => 'max:45',
        ],[
            'name.required'          => 'El name es requerido',
            'name.max'               => 'El name debe contener como máximo 45 caracteres',
            'rut.required'           => 'El rut es requerido',
            'rut.max'                => 'El rut debe contener como máximo 45 caracteres',
            'razonsocial.required'   => 'El razonsocial es requerido',
            'razonsocial.max'        => 'El razonsocial debe contener como máximo 45 caracteres',
            'rutlegal.max'           => 'El rutlegal debe contener como máximo 45 caracteres',
            'direccion.required'     => 'El direccion es requerido',
            'direccion.max'          => 'El direccion debe contener como máximo 45 caracteres',
            'telefono.required'      => 'El telefono es requerido',
            'telefono.max'           => 'El telefono debe contener como máximo 45 caracteres',
            'email.required'         => 'El email es requerido',
            'email.max'              => 'El email debe contener como máximo 45 caracteres',
            'comentario.max'         => 'El comentario debe contener como máximo 45 caracteres',
            'habilitar.max'          => 'El habilitar debe contener como máximo 45 caracteres',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $element = Account::create([
            'name' => $request->get('name'),
            'rut' => $request->get('rut'),
            'razonsocial' => $request->get('razonsocial'),
            'rutlegal' => $request->get('rutlegal')?$request->get('rutlegal'):null, 
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'comentario' => $request->get('comentario')?$request->get('comentario'):null,
            'habilitar' => $request->get('habilitar')?$request->get('habilitar'):null,
            'turn' => $request->get('turn')?$request->get('turn'):null,
            'adviser_name' => $request->get('adviser_name')?$request->get('adviser_name'):null,
            'adviser_rut' => $request->get('adviser_rut')?$request->get('adviser_rut'):null,
            'adviser_telefono' => $request->get('adviser_telefono')?$request->get('adviser_telefono'):null,
            'agent_name' => $request->get('agent_name')?$request->get('agent_name'):null,
            'agent_rut' => $request->get('agent_rut')?$request->get('agent_rut'):null,
            'agent_telefono' => $request->get('agent_telefono')?$request->get('agent_telefono'):null,
            'admin_status'=>$request->get('admin_status')?$request->get('admin_status'):null,
            'client_type'=>$request->get('client_type')?$request->get('client_type'):null,
            'platform'=>$request->get('platform')?$request->get('platform'):null,
        ]);
        $response = [
            'message'=> 'Cuenta registrada satisfactoriamente',
            'data' => $element->with("farms")->first(),
        ];
        return response()->json($response, 200);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:45',
            'rut'             => 'required|string|max:45',
            'razonsocial'     => 'required|string|max:45',
            'rutlegal'        => 'max:45',
            'direccion'       => 'required|string|max:45',
            'telefono'        => 'required|string|max:45',
            'email'           => 'required|string|max:45',
            'comentario'      => 'max:45',
            'habilitar'       => 'max:45',
        ],[
            'name.required'          => 'El name es requerido',
            'name.max'               => 'El name debe contener como máximo 45 caracteres',
            'rut.required'           => 'El rut es requerido',
            'rut.max'                => 'El rut debe contener como máximo 45 caracteres',
            'razonsocial.required'   => 'El razonsocial es requerido',
            'razonsocial.max'        => 'El razonsocial debe contener como máximo 45 caracteres',
            'rutlegal.max'           => 'El rutlegal debe contener como máximo 45 caracteres',
            'direccion.required'     => 'El direccion es requerido',
            'direccion.max'          => 'El direccion debe contener como máximo 45 caracteres',
            'telefono.required'      => 'El telefono es requerido',
            'telefono.max'           => 'El telefono debe contener como máximo 45 caracteres',
            'email.required'         => 'El email es requerido',
            'email.max'              => 'El email debe contener como máximo 45 caracteres',
            'comentario.max'         => 'El comentario debe contener como máximo 45 caracteres',
            'habilitar.max'          => 'El habilitar debe contener como máximo 45 caracteres',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try {
            $account = Account::find($id);
            if(is_null($account)){
                return response()->json(["message"=>"Cuenta no existente"],404);
            }
            $account->fill($request->all());
            foreach ($request->get('farms') as $key => $value) {
                $farm = Farm::find($value["id"]);
                $farm->total_area=$value["total_area"];//superficie total
                $farm->amount_equipment_irrigation=$value["amount_equipment_irrigation"];//Cantidad de equipos de Riego
                $farm->number_sectors_irrigation=$value["number_sectors_irrigation"];//Cantidad de sectores de Riego
                $farm->quantity_wells=$value["quantity_wells"];//cantidad de pozos
                $farm->start_installation=$value["start_installation"]?$value["start_installation"]:$farm->start_installation;//inicio de instalacion
                $farm->end_installation=$value["end_installation"]?$value["end_installation"]:$farm->end_installation;//fin de instalacion
                $farm->update();
            }
            $response = [
                'message'=> 'Campo actualizado satisfactoriamente',
                'data' => $account->with("farms")->first(),
            ];
            $account->update();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de guardar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
}
