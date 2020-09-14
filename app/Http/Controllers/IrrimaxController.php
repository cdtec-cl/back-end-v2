<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class IrrimaxController extends Controller
{
    protected function requestApi($client,$method,$uri){
        return $client->request($method, $uri, [
            'headers' => [
                'Accept'     => 'application/json'
            ]
        ]);
    }
    public function query(Request $request){
    	try {
    		$apiResponse = $this->requestApi(new Client([
    			'base_uri' => $request->get('url'),
    			'timeout'  => 1000.0,
    		]),'GET','')->getBody()->getContents();

    		$response = [
    			'message'=> 'Respuesta de api',
    			'data'=> $apiResponse,
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
