<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Requests;
use App\Http\Requests\UserRequest;

class UserController extends BaseController
{
    protected $model = User::class;

    protected function getValidationRules()
    {
         return (new UserRequest())->rules();
    }

    // public function register(UserRequest $request)
    // {
    //     // Валидация запроса
    //     $validatedData = $request->validated();

    //     // Создание пользователя
    //     $user = User::create([
    //         'login' => $validatedData['login'],
    //         'password' => Hash::make($validatedData['password']),
    //         'name' => $validatedData['name'],
    //         'address' => $validatedData['address'],
    //         'email' => $validatedData['email'],
    //         'phone' => $validatedData['phone'],
    //     ]);

    //     // Создание клиента Passport, если его еще нет
    //     $client = Client::where('password_client', true)->first();

    //     // Генерация API токена для пользователя
    //     $tokenResult = $user->createToken('Personal Access Token', [$client->id]);
    //     $token = $tokenResult->accessToken;

    //     // Возвращение ответа с данными пользователя и сгенерированным токеном
    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'access_token' => $token,
    //     ], 201);
    // }
}
