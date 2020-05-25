<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasPermissionTo('isAdmin')) {
            $categories=Category::latest()->paginate(10);
        }else{
            $categories=Category::where('user_id',auth()->user()->id)->latest()->paginate(10);
        }
        return $categories;
    }

    public function search(Request $request)
    {
        if(auth()->user()->hasPermissionTo('isAdmin')) {
            $categories = Category::where('name', 'LIKE', '%' . $request->keywords . '%')
                ->paginate(10);
        }else{
            $categories = Category::where('user_id',auth()->user()->id)->where('name', 'LIKE', '%' . $request->keywords . '%')
                ->paginate(10);
        }
    	return $categories;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        try {
            Category::create([
                'name' => $request->name,
                'fav' => $request->fav,
                'user_id'=>auth()->user()->id,
                'slug'=>Str::slug($request->name)
            ]);
            return response()->json(1, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->fav = $request->fav;

            $category->save();
    		return response()->json(1, 200);
    	} catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }


    public function destroy($id)
    {

        $category=Category::find($id);
        $category->delete();
    	return response()->json(1, 200);
    }
}
