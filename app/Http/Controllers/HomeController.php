<?php

namespace App\Http\Controllers;


use App\Board;
use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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


        $limit = (auth()->user()->getSetting('notifications-show-limit')) ? auth()->user()->getSetting('notifications-show-limit')->value : 10;

        $data = [
            'allNoti' => auth()->user()->notifications->take($limit),
            'newNoti' => auth()->user()->unreadNotifications->take($limit),
            'oldNoti' => auth()->user()->readNotifications->take($limit),
        ];

        auth()->user()->unreadNotifications->markAsRead();
        $coin = (auth()->user()->level == 3) ? auth()->user()->getSetting('currency')->value : 'N';
        $tables = [
            'all' => Board::where('user_id', auth()->user()->id)->get()->count(),
            'data' => Board::where('user_id', auth()->user()->id)->get()
        ];
        $cats = [
            'all' => Category::where('user_id', auth()->user()->id)->get()->count()

        ];
        $itemQuery = Item::where('user_id', auth()->user()->id);
        $items = [
            'all' => $itemQuery->get()->count(),
            'data' => $itemQuery->orderBy('view', 'desc')->take(10)->get(),
            'max' => $itemQuery->get()->max('view')
        ];

        $acl = [
            'access_rest_statistic' => (Gate::allows('access_rest_statistic')) ? true : false,
            'access_grand_statistic' => (Gate::allows('access_grand_statistic')) ? true : false,
            'access_agent_statistic' => (Gate::allows('access_agent_statistic')) ? true : false,
            'access_admin_statistic' => (Gate::allows('access_admin_statistic')) ? true : false,
        ];



        return view('home', compact([
            'acl',
            'data',
            'tables',
            'cats',
            'items',
            'coin'
        ]));
    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}