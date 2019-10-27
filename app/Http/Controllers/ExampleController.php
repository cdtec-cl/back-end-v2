<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
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
            $examples = Example::all();
            return response()->json([$examples], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    //
}
