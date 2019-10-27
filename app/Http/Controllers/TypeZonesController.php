<?php

namespace App\Http\Controllers;

use App\TypeZone;
use Illuminate\Http\Request;

class TypeZoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function index(Request $request)
    {
        if($request->isJson()) {
            $type_zones = TypeZone::all();
            return response()->json([$type_zones], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    //
}
