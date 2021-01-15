<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PolygonCreationController extends Controller
{
    public function saveFile(Request $request){
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name = time() . '-kml.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put($name,file_get_contents($file));
            }
            $response = [
                'message'=> 'Archivo guardado',
                'data' => asset("storage/".$name),
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
