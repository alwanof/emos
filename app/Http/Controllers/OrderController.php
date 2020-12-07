<?php

namespace App\Http\Controllers;

use App\Hook;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function rightNow()
    {
        $actor = auth()->user();

        if ($actor->hasRole('restaurant')) {
            if ($actor->parent['rest'] != $actor->id) {
                $actor = User::find($actor->parent['rest']);
            }
        }
        $acl = [
            'access_orders' => (Gate::allows('access_orders')) ? true : false,
            'access_right_now' => (Gate::allows('access_right_now')) ? true : false,
            'order_pickitup' => (Gate::allows('order_pickitup')) ? true : false,
            'order_handover' => (Gate::allows('order_handover')) ? true : false,
            'access_order_new' => (Gate::allows('access_order_new')) ? true : false,
            'access_order_waiting' => (Gate::allows('access_order_waiting')) ? true : false,
            'access_order_done' => (Gate::allows('access_order_done')) ? true : false,
            //'isAdmin' => (Gate::allows('isAdmin')) ? true : false,
        ];



        return view('order.new', compact(['acl', 'actor']));
    }
    public function remote()
    {
        $actor = auth()->user();

        if ($actor->hasRole('restaurant')) {
            if ($actor->parent['rest'] != $actor->id) {
                $actor = User::find($actor->parent['rest']);
            }
        }
        $acl = [
            'access_orders' => (Gate::allows('access_orders')) ? true : false,
            'access_remote_now' => (Gate::allows('access_remote_now')) ? true : false,
            'remote_pickitup' => (Gate::allows('remote_pickitup')) ? true : false,
            'remote_handover' => (Gate::allows('remote_handover')) ? true : false,
            'access_remote_new' => (Gate::allows('access_remote_new')) ? true : false,
            'access_remote_waiting' => (Gate::allows('access_remote_waiting')) ? true : false,
            'access_remote_done' => (Gate::allows('access_remote_done')) ? true : false,
            //'isAdmin' => (Gate::allows('isAdmin')) ? true : false,
        ];



        return view('order.remote', compact(['acl', 'actor']));
    }
    public function printInvoice($orderID, $pureTotal, $tax, $note = null, $address = null, $name = null, $phone = null)
    {

        $actor = auth()->user();

        if ($actor->hasRole('restaurant')) {
            if ($actor->parent['rest'] != $actor->id) {
                $actor = User::find($actor->parent['rest']);
            }
        }

        return view('order.print', compact(['orderID', 'pureTotal', 'actor', 'tax', 'note', 'address', 'name', 'phone']));
    }
    public function stack()
    {

        $acl = [];
        $hook = Hook::where('user_id', auth()->user()->id)->get()->pluck('category_id')->toArray();
        $rest = User::find(auth()->user()->ref);


        return view('stack.index', compact(['acl', 'hook', 'rest']));
    }
}
