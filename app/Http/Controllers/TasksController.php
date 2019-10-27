<?php

use App\Task;
namespace App\Http\Controllers;

class TasksController extends Controller
{
    public function __construct()
    {
        //
    }

    public function show(){
        return 'SHOW taskS';
    }

    public function get(){
        return 'GET taskS';
    }

    //
}
