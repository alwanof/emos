<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index()
    {

        return User::latest()->paginate(10);
    }

    public function search(Request $request)
    {
        $users = User::where('name', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('email', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('refType', 'LIKE', '%' . $request->keywords . '%')
            ->paginate(10);

        return $users;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(10),
                'level'=>$request->level,
                'refType'=>$request->refType,
                'ref'=>$request->ref
            ]);
            return response()->json(1, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }





    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();
        return response()->json(1, 200);
    }
}
