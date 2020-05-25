<?php

namespace App\Http\Controllers;


use App\Board;
use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $limit=auth()->user()->getSetting('notifications-show-limit')->value;

        $data=[
            'allNoti'=>auth()->user()->notifications->take($limit),
            'newNoti'=>auth()->user()->unreadNotifications->take($limit),
            'oldNoti'=>auth()->user()->readNotifications->take($limit),
        ];

        auth()->user()->unreadNotifications->markAsRead();
        $tables=[
            'all'=>Board::where('user_id',auth()->user()->id)->get()->count(),
            'data'=>Board::where('user_id',auth()->user()->id)->get()
        ];
        $cats=[
            'all'=>Category::where('user_id',auth()->user()->id)->get()->count()

        ];
        $items=[
            'all'=>Item::where('user_id',auth()->user()->id)->get()->count(),
            'data'=>Item::where('user_id',auth()->user()->id)->orderBy('view','desc')->take(10)->get()
        ];



        return view('home',compact([
            'data',
            'tables',
            'cats',
            'items'
        ]));
    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
