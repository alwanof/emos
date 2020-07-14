<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class HookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return 99;
        $categories=Category::where('user_id',auth()->user()->id)->get();;
        $operators=User::where('ref',auth()->user()->id)->get();

        return view('hooks.index', compact(['operators','categories']));
    }
}
