<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(User $request)
    {
        $user = User::create($request->all());

        //dd($user);
        return response()->json($user,201);
    }

    public function item($id)
    {
        //dd($id);
        $user = User::with('users')->findOrFail($id);
        return response()->json($user,200);
    }
    public function list(Request $request)
    {
        $users = User::where('id', '>', 2)->paginate(5);
        return response()->json($users, 200);
    }

    public function update(Request $request, $id)
    {
          $user = User::findOrFail($id);
          $user -> update($request->all());
          return response()->json($user, 200);
    }
     public function delete($id)
    {
          $user = User::findOrFail($id);
          $user->delete();
          return response()->json($user, 204);
    }
}
