<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Graph;
class GraphController extends Controller
{
    public function all(){
        try {
            $response = [
                'message'=> 'Lista de graficas',
                'data' => Graph::all(),
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
