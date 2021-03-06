<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\FarmsUsers;
use App\Farm;
use App\User;
use App\Account;
class FarmsUsersController extends Controller
{
    public function all(){
        try {
            $response = [
                'message'=> 'Lista de campos por usuarios',
                'data' => FarmsUsers::with('farm')->with('user')->get(),
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
            $element = FarmsUsers::find($id);
            if(is_null($element)){
                return response()->json([
                    'message'=>'No existe el campo del usuario',
                    'data'=>$element
                ],404);
            }
            $response = [
                'message'=> 'Campo del usuario encontrado',
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
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_farm'          => 'required|integer',
            'id_user'          => 'required|integer',
        ],[
            'id_farm.required'    => 'El campo es requerido',
            'id_farm.integer'     => 'El campo debe ser un entero',
            'id_user.required'    => 'El usuario es requerido',
            'id_user.integer'     => 'El usuario debe ser un entero',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try{
        	$farm = Farm::find($request->get('id_farm'));
        	$user = User::find($request->get('id_user'));
	        $messages=[];
            if(is_null($farm)||is_null($user)){
                if(is_null($farm)){
                	array_push($messages,'Campo no existente');
                }
                if(is_null($user)){
                	array_push($messages,'Usuario no existente');
                }
                return response()->json(['message'=>$messages],404);
            }
			if(is_null(FarmsUsers::where('id_farm',$request->get('id_farm'))
        		->where('id_user',$request->get('id_user'))
        		->first())){
                $element = FarmsUsers::create([
	                'id_farm' => $request->get('id_farm'),
	                'id_user' => $request->get('id_user'),         
	            ]);
	            $response = [
	                'message'=> 'Campo de usuario registrado',
	                'data' => $element,
	            ];
	            return response()->json($response, 200);
            }
            return response()->json(['message'=>['El campo ya pertenece a la usuario']],404);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de guardar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'id_farm'          => 'required|integer',
            'id_user'          => 'required|integer',
        ],[
            'id_farm.required'    => 'El campo es requerido',
            'id_farm.integer'     => 'El id del campo debe ser un entero',
            'id_user.required'    => 'El usuario es requerido',
            'id_user.integer'     => 'El id del usuario debe ser un entero',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        try {
            $farm = Farm::find($request->get('id_farm'));
        	$user = User::find($request->get('id_user'));
	        $farmUser= FarmsUsers::find($id);
	        $messages=[];
            if(is_null($farm)||is_null($user)||is_null($farmUser)){
                if(is_null($farm)){
                	array_push($messages,'Campo no existente');
                }
                if(is_null($user)){
                	array_push($messages,'Usuario no existente');
                }
                if(is_null($farmUser)){
                	array_push($messages,'Campo de usuario no existente');
                }
                return response()->json(['message'=>$messages],404);
            }
			if(is_null(FarmsUsers::where('id_farm',$request->get('id_farm'))
        		->where('id_user',$request->get('id_user'))
        		->first())){
                $farmUser->fill($request->all());
            	$response = [
            	    'message'=> 'Campo de usuario actualizado',
            	    'data' => $farmUser,
            	];
            	$farmUser->update();
            	return response()->json($response, 200);
            }
            return response()->json(['message'=>['El campo ya pertenece a la usuario']],404);            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de guardar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
    public function delete($id){
        try {
            $element = FarmsUsers::find($id);
            if(is_null($element)){
                return response()->json(['message'=>'Campo de usuario no existente'],404);
            }
            $response = [
                'message'=> 'Campo de usuario eliminado satisfactoriamente',
                'data' => $element,
            ];
            $element->delete();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al tratar de eliminar los datos.',
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
}
