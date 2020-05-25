<?php

namespace App\Http\Controllers\API;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {

        if(auth()->user()->hasPermissionTo('isAdmin')) {
            $items=Item::with('category')->latest()->paginate(10);
        }else{
            $items=Item::with('category')->where('user_id',auth()->user()->id)->latest()->paginate(10);
        }

        return $items;
    }

    public function search(Request $request)
    {
        if(auth()->user()->hasPermissionTo('isAdmin')) {
            $items = Item::with('category')->where('title', 'LIKE', '%' . $request->keywords . '%')
                ->orWhere('description', 'LIKE', '%' . $request->keywords . '%')
                ->paginate(10);
        }else{
            $items = Item::with('category')->where('user_id',auth()->user()->id)->where('title', 'LIKE', '%' . $request->keywords . '%')
                ->paginate(10);
        }


   	return $items;
   }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required',
        ]);
        try {
            Item::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube' => $request->youtube,
                'price' => $request->price,
                'user_id'=>auth()->user()->id,
                'available' => $request->available,
                'category_id' => $request->category_id,

            ]);
            return response()->json(1, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'price' => 'required|numeric|min:1',
        ]);
        try {
            $item = Item::findOrFail($id);
   		    $item->title = $request->title;
            $item->slug = Str::slug($request->title);
   		    $item->description = $request->description;
   		    $item->youtube = $request->youtube;
   		    $item->price = $request->price;
   		    $item->available = $request->available;
   		    $item->category_id = $request->category_id;

   		    $item->save();
   		    return response()->json(1, 200);
   	} catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }


    public function destroy($id)
    {

        $items=Item::find($id);
        $items->delete();
   	return response()->json(1, 200);
   }
}
