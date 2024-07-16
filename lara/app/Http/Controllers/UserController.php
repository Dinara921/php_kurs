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

    protected function register(UserRequest $request)
    {
        //TODO Условия в классе реквесте на уникальность    
        //TODO Брать пароль в реквесте и кодировать
        $userData = $request->all();
        $userData ['password'] = bcrypt($request);
        $item = $this->model::create($userData);
        return response()->json($item, 201);
        //TODO Сохранить пользователя в базу
    }

    protected function login(LoginRequest $request)
    {
        //TODO искать пользователя почте
        $userData = $request->all();
        //TODO Брать пароль в реквесте и кодировать
        $userData['password'] = bcrypt($request);
        //TODO Сравнить кодированный пароль и пароль в базе 
        $item = $this->model::where('email', 'like' $userData[email]);
        //TODO При успешном условии генерировать случайный токен
        if($item->password !== $userData['password'])
        {
            throw new PasswordNotCorrect();
        }

        $token = str_random(30);

        $item->token = $token;
        $item->save();
        return $item;
        
        
        return response()->json($item, 201);
        
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
