<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($restaurant)
    {
        $feeds=Category::where('user_id',$restaurant)->with('items')->get();
        return $feeds;
    }

    public function get_cats($restaurant)
    {
        $feeds=Category::where('user_id',$restaurant)->get();
        return $feeds;
    }

    public function love($id)
    {
        try {
            $item=Item::find($id);
            $item->view=$item->view+1;
            $item->save();
            return response()->json(1, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }


    }


}
