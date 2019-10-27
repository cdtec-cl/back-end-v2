<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
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
            $accounts = Account::all();
            return response()->json([$accounts], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401, [] );
    }

    //
}
