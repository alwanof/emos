<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:access_menu_manager']);
    }

    public function index(){
        $acl = [

            'access_menu_manager' => (Gate::allows('access_menu_manager')) ? true : false,
            'access_tables' => (Gate::allows('access_tables')) ? true : false,
            ];


        return view('board.index',compact(['acl']));
    }

    public function print_qrcode(Board $board){

        return view('menu.qrcode',compact(['board']));
    }
}
