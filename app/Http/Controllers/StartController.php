<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartController extends Controller
{
    public function index(){
        echo "Hello world";
    }

    public function tableIsbusy(){
        return view('tableisbusy');
    }
}
