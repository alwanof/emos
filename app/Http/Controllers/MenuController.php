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
        $theme=($user->getSetting('theme'))?$user->getSetting('theme')->value:'default';


        $colors=[
            'bcolor'=>($user->getSetting('background-color'))?$user->getSetting('background-color')->value:'#34495e',
            'fcolor'=>($user->getSetting('text-color'))?$user->getSetting('text-color')->value:'#e74c3c',
            'dark'=>($user->getSetting('dark'))?$user->getSetting('dark')->value:1
        ];


        return view('menu.'.$theme,compact(['restaurant','table','session','cats','colors']));

    }
    public function remote($restaurant){

        $user=User::where('slug',$restaurant)->first();

        if(!$user){
            return abort(404);
        }
        $restaurant=$user;
        $session = Session::getId();
        $cats=Category::where('user_id',$restaurant->id)->get();
        $theme= ($user->getSetting('theme'))?$user->getSetting('theme')->value:'default';

        $colors=[
            'bcolor'=>($user->getSetting('background-color'))?$user->getSetting('background-color')->value:'#34495e',
            'fcolor'=>($user->getSetting('text-color'))?$user->getSetting('text-color')->value:'#e74c3c',
            'dark'=>($user->getSetting('dark'))?$user->getSetting('dark')->value:1
        ];

        return view('menu.remote.'.$theme,compact(['restaurant','session','cats','colors']));

    }

    public function print_all(User $user){
        $tables=Board::where('user_id',$user->id)->get();

        return view('menu.all',compact(['tables']));
    }


}
