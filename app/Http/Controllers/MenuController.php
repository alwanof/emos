<?php

namespace App\Http\Controllers;

use App\Board;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MenuController extends Controller
{
    public function index($restaurant,$table){

        $user=User::where('slug',$restaurant)->first();
        if(!$user){
            return abort(404);
        }
        $restaurant=$user;
        $table=Board::where('slug',$table)->first();
        if(!$table){
            return abort(404);
        }
        $session = Session::getId();
        $cats=Category::where('user_id',$restaurant->id)->get();


        return view('menu.default',compact(['restaurant','table','session','cats']));

    }

    public function print_all(User $user){
        $tables=Board::where('user_id',$user->id)->get();

        return view('menu.all',compact(['tables']));
    }


}
