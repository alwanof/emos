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
    public function index($restaurant, $table)
    {


        $user = User::with('settings')->where('slug', $restaurant)->first();
        if (!$user) {
            return abort(404);
        }


        $restaurant = $user;

        $table = Board::where('slug', $table)->first();
        if (!$table) {
            return abort(404);
        }
        $session = Session::getId();
        $cats = Category::where('user_id', $restaurant->id)->get();
        $theme = ($user->getSetting('theme')) ? $user->getSetting('theme')->value : 'default';


        $colors = [
            'bcolor' => ($user->getSetting('background-color')) ? $user->getSetting('background-color')->value : '#34495e',
            'fcolor' => ($user->getSetting('text-color')) ? $user->getSetting('text-color')->value : '#e74c3c',
            'dark' => ($user->getSetting('dark')) ? $user->getSetting('dark')->value : 1
        ];


        return view('menu.' . $theme, compact(['restaurant', 'table', 'session', 'cats', 'colors']));
    }

    public function remote(Request $request, $restaurant)
    {


        $param = [
            'clientID' => (isset($request->clientID)) ? $request->clientID : null,
            'name' => (isset($request->name)) ? $request->name : null,
            'trend_id' => (isset($request->trend_id)) ? $request->trend_id : null,
            'hotel_id' => (isset($request->hotel_id)) ? $request->hotel_id : null,
            'hotel_name' => (isset($request->hotel_name)) ? $request->hotel_name : null,
            'room_no' => (isset($request->room_no)) ? $request->room_no : null,
            'passport_no' => (isset($request->passport_no)) ? $request->passport_no : null,
            'dob' => (isset($request->dob)) ? $request->dob : null,
            'email' => (isset($request->email)) ? $request->email : null,
            'phone' => (isset($request->phone)) ? $request->phone : null,
            'address' => (isset($request->address)) ? $request->address : null,
        ];

        $user = User::with('settings')->where('slug', $restaurant)->first();

        if (!$user) {
            return abort(404);
        }
        $restaurant = $user;
        $session = Session::getId();
        $cats = Category::where('user_id', $restaurant->id)->get();
        $theme = ($user->getSetting('theme')) ? $user->getSetting('theme')->value : 'default';

        $colors = [
            'bcolor' => ($user->getSetting('background-color')) ? $user->getSetting('background-color')->value : '#34495e',
            'fcolor' => ($user->getSetting('text-color')) ? $user->getSetting('text-color')->value : '#e74c3c',
            'dark' => ($user->getSetting('dark')) ? $user->getSetting('dark')->value : 1
        ];

        return view('menu.remote.' . $theme, compact(['restaurant', 'session', 'cats', 'colors', 'param']));
    }
}
