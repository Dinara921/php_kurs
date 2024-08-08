<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserIdRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    protected $model = User::class;

    protected function getValidationRules()
    {
         return (new UserRequest())->rules();
    }

    protected function register(UserRequest $request)
    {
        //TODO Условия в классе реквесте на уникальность

        //TODO Брать пароль в реквесте и кодировать
        $userData = $request->all();
        $userData ['password'] = Hash::make($userData['password']);
        //TODO Сохранить пользователя в базу
        $item = $this->model::create($userData);
        return response()->json($item, 201);
    }

    protected function login(LoginRequest $request)
    {
        //TODO искать пользователя почте
        $userData = $request->all();
        //TODO Брать пароль в реквесте и кодировать
        //TODO Сравнить кодированный пароль и пароль в базе 
        $item = $this->model::where('email', 'like', $userData['email'])->first();
        //TODO При успешном условии генерировать случайный токен

        if(Hash::check($userData['password'], $item->password) == false)
        {
            throw new PasswordNotCorrect();
        }

        $token = Str::random(30);

        $item->token = $token;
        $item->save();
        return response()->json(['user' => $item, 'token' => $token], 200);
    }

    public function logout(LoginRequest $request)
    {
        $token = $request->bearerToken();

        \Log::info('Token received for logout:', ['token' => $token]);

        if (!$token) {
            return response()->json(['message' => 'No token provided'], 400);
        }

        try {
            $user = User::where('token', $token)->first();

            if (!$user) {
                \Log::info('No user found with token:', ['token' => $token]);
                return response()->json(['message' => 'Invalid token'], 400);
            }

            $user->token = null;
            $user->save();

            return response()->json(['message' => 'Logout successful'], 200);
        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function getUserIdByToken(UserIdRequest $request)
    {
        $token = $request->input('token');

        \Log::info('Token received:', ['token' => $token]);

        if (!$token) {
            return response()->json(['message' => 'No token provided'], 400);
        }

        $user = User::where('token', $token)->first();

        if (!$user) {
            \Log::info('No user found with token:', ['token' => $token]);
            return response()->json(['message' => 'Invalid token'], 400);
        }

        return response()->json(['user_id' => $user->id], 200);
    }
}
