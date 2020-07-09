<?php

namespace App\Http\Controllers\API;

use App\Hook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HookController extends Controller
{
    public function index()
    {


        return Hook::where('ref',auth()->user()->id)->latest()->paginate(10);
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'user_id' => 'required',
        ]);
        try {
            Hook::create([
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
                'ref'=>auth()->user()->id
            ]);
            return response()->json(1, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }




    public function destroy($id)
    {

        $hook = Hook::find($id);
        $hook->delete();
        return response()->json(1, 200);
    }
}
