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
        //TODO Сохранить пользователя в базу
        $item = $this->model::create($userData);
        return response()->json($item, 201);
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

    protected function logout(LoginRequest $request)
    {
        $userData = $request->all();

        $item = $this->model::where('email', $userData['email'])->first();

        if (!$item || !Hash::check($userData['password'], $item->password)) 
        {
            throw new PasswordNotCorrect();
        }

        $item->token = null; 
        $item->save();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
