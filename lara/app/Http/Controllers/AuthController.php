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
        $credentials = $request->only('login', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $client = Client::where('password_client', true)->first();

        $tokenResult = $user->createToken('Personal Access Token', [$client->id]);
        $token = $tokenResult->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
        ], 200);
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
