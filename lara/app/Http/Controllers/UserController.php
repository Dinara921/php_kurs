<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Requests;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function create(UserRequest $request)
    {
        $user = User::create($request->all());

        //dd($user);  
        return response()->json($user,201);
    }

    public function item($id)
    {
        //dd($id);
        $user = User::findOrFail($id);
        return response()->json($user,200);
    }

    public function list(UserRequest $request)
    {
        $users = User::where('id', '>', 2)->paginate(5);
        return response()->json($users, 200);
    }

    public function update(UserRequest $request, $id)
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
