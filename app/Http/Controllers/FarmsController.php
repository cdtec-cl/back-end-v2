<?php

use App\Farm;
namespace App\Http\Controllers;

class FarmsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function show(){
        return 'SHOW FARMS';
    }

    public function get(){
        return 'GET FARMS';
    }

    //
}
