<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Метод для аутентификации пользователя и выдачи токена.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        public function register(CreateUserRequest $request)
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        }

        public function login(LoginRequest $request)
        {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = Auth::user();

            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        }

        public function logout()
        {
            Auth::logout();

            return response()->json(['message' => 'Logged out'], 200);
        }
    }

    /**
     * Метод для выхода пользователя (удаления токена).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
