<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function rightNow(){
        $acl = [
            'access_orders' => (Gate::allows('access_orders')) ? true : false,
            'access_right_now' => (Gate::allows('access_right_now')) ? true : false,
            'order_pickitup' => (Gate::allows('order_pickitup')) ? true : false,
            'order_handover' => (Gate::allows('order_handover')) ? true : false,
            'isAdmin' => (Gate::allows('isAdmin')) ? true : false,
        ];



        return view('order.new', compact(['acl']));
    }
    public function remote(){
        $acl = [
            'access_orders' => (Gate::allows('access_orders')) ? true : false,
            'access_right_now' => (Gate::allows('access_right_now')) ? true : false,
            'order_pickitup' => (Gate::allows('order_pickitup')) ? true : false,
            'order_handover' => (Gate::allows('order_handover')) ? true : false,
            'isAdmin' => (Gate::allows('isAdmin')) ? true : false,
        ];



        return view('order.remote', compact(['acl']));
    }
}
