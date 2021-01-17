<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Farm;
use App\Zone;
use App\FarmGoogleMapsFile;
use App\ZoneCoordinatesMap;
class PolygonCreationController extends Controller
{
    public function getByFarm($id){
        try {
            $farm = Farm::find($id)->first();
            if(is_null($farm)){
                return response()->json([
                    'message'=>'Campo no existente',
                    'data'=>$farm
                ],404);
            }
            $farmGoogleMapsFile = FarmGoogleMapsFile::where('id_farm',$farm->id)->orderBy('created_at', 'desc')->first();
            $response = [
                'message'=> 'Elemento encontrado',
                'data' => $farmGoogleMapsFile,
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
    public function saveFile(Request $request,$id){
        try {
            $farm = Farm::find($id);
            if(is_null($farm)){
                return response()->json([
                    'message'=>'Campo no existente',
                    'data'=>$farm
                ],404);
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name = time() . '-kml.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put($name,file_get_contents($file));
                $farmGoogleMapsFile=new FarmGoogleMapsFile();
                $farmGoogleMapsFile->id_farm=$farm->id;
                $farmGoogleMapsFile->path_file=asset("storage/".$name);
                $farmGoogleMapsFile->save();
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
    public function linkSector(Request $request,$id){
        try {
            $zone = Zone::find($id);
            if(is_null($zone)){
                return response()->json([
                    'message'=>'Zona no existente',
                    'data'=>$zone
                ],404);
            }
            $zoneCoordinatesMap = new ZoneCoordinatesMap();
            $zoneCoordinatesMap->id_zone=$zone->id;
            $zoneCoordinatesMap->lat=$request->get('lat');
            $zoneCoordinatesMap->lng=$request->get('lng');
            $zoneCoordinatesMap->save();
            $response = [
                'message'=> 'Zona vinculada a coordenadas',
                'data' => $zoneCoordinatesMap,
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
