<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:access_menu_manager']);
    }

    public function index(){
        $acl = [

            'access_menu_manager' => (Gate::allows('access_menu_manager')) ? true : false,
            'access_items' => (Gate::allows('access_items')) ? true : false,
            'edit_items' => (Gate::allows('edit_items')) ? true : false,
            'delete_items' => (Gate::allows('delete_items')) ? true : false,
        ];

        $categories=Category::where('user_id',auth()->user()->id)->get();
        return view('item.index',compact(['acl','categories']));
    }
    function profile($item)
    {
        try {
            $item = Item::findOrFail($item);
            return view('item.profile', compact(['item']));
        } catch (Exception $e) {
            abort(403);
        }
    }
}
