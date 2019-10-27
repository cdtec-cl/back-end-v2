<?php

namespace App\Http\Controllers;

use App\Zone;
use Illuminate\Http\Request;

class ZonesController extends Controller
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
            $zones = Zone::all();
            return response()->json([$zones], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    //
}
