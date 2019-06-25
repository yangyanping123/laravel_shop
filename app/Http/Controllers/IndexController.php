<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index()
    {
       $info=  DB::table('users')->get();

    //var_dump(json_encode($info));


    }
}
