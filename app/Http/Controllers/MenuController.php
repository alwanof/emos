<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MenuController extends Controller
{
    public function index($restaurant,$table){

        $restaurant=User::where('slug',$restaurant)->first();
        $table=Board::where('slug',$table)->first();
        $session = Session::getId();


        return view('menu.index',compact(['restaurant','table','session']));

    }


}
