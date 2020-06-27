<?php

namespace App\Http\Controllers\API;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    public function index()
    {

        return Board::where('user_id',auth()->user()->id)->latest()->paginate(10);
    }

    public function search(Request $request)
    {
        $boards = Board::where('user_id',auth()->user()->id)->where('name', 'LIKE', '%' . $request->keywords . '%')
        ->paginate(10);
    	return $boards;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        try {
            Board::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'user_id'=>auth()->user()->id

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
            $board = Board::findOrFail($id);
            $board->name = $request->name;
            $board->slug= Str::slug($request->name);

            $board->save();
    		return response()->json(1, 200);
    	} catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }


    public function destroy($id)
    {

        $board=Board::find($id);
        $board->delete();
    	return response()->json(1, 200);
    }

    public function tables()
    {
        $boards = Board::where('user_id',auth()->user()->id)->get()->count();
        return $boards;
    }
}
