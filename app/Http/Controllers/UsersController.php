<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    function index(Request $request)
    {
        if($request->isJson()) {
            $users = User::all();
            return response()->json([$users], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    function create(Request $request)
    {
        if($request->isJson()) {
            $data = $request->all();
            $new_user = [
                'name' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'api_token' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 60)
            ];
            $user = User::create($new_user);
            return response()->json([$user], 201);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    function getToken(Request $request){
        if($request->isJson()){
            try{
                $data = $request->json()->all();

                /*
                if(isset($data['username']) && isset($data['username'])){
                    return response()->json(['error' => 'CTM'], 406);
                }
                */

                $user = User::where('username', $data['username'])->first();

                if($user && Hash::check($data['password'], $user->password)) {
                    return response()->json($user, 200);
                }

                return response()->json(['error' => 'No content'], 406);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'No content'], 406);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 406);

    }
}
