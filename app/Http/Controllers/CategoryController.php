<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:access_menu_manager']);
    }

    public function index(){
        $acl = [

            'access_menu_manager' => (Gate::allows('access_menu_manager')) ? true : false,
            'access_categories' => (Gate::allows('access_categories')) ? true : false,
            'edit_categories' => (Gate::allows('edit_categories')) ? true : false,
            'delete_categories' => (Gate::allows('delete_categories')) ? true : false,
        ];


        return view('category.index',compact(['acl']));
    }
}
