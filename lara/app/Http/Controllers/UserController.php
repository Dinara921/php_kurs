<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserIdRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    protected $model = User::class;

    protected function getValidationRules()
    {
         return (new UserRequest())->rules();
    }

    protected function register(UserRequest $request)
    {
        $existingUser = $this->model::where('email', $request->email)->first();

        if ($existingUser) 
        {
             return response()->json([
            'status' => 'error',
            'message' => 'Пользователь с таким email уже существует'
        ], 200);
        }
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

    public function getUserIdByToken(UserIdRequest $request)
    {
        $token = $request->input('token');

        \Log::info('Token received:', ['token' => $token]);

        if (!$token) 
        {
            return response()->json(['message' => 'No token provided'], 400);
        }

        $user = User::where('token', $token)->first();

        if (!$user) 
        {
            \Log::info('No user found with token:', ['token' => $token]);
            return response()->json(['message' => 'Invalid token'], 400);
        }

        return response()->json(['user_id' => $user->id], 200);
    }

    public function registerAndOrder(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|max:20', 
            'name' => 'nullable|string', 
            'address' => 'required|string|max:255',  
            'phone' => 'nullable|numeric',
            'cartItems' => 'required|array',
            'cartItems.*.id' => 'required|integer',
            'cartItems.*.count' => 'required|integer',
            'cartItems.*.price' => 'required|numeric',
        ]);

        $data = $request->all();

        DB::beginTransaction();

        try 
        {
             $existingUser = User::where('email', $data['email'])->first();
             if ($existingUser) 
             {
                return response()->json(['error' => 'Пользователь с таким email уже существует'], 400);
             }

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'name' => $data['name'],
                'address' => $data['address'],
                'phone' => $data['phone']
            ]);
            
            $token = Str::random(30);
            $user->token = $token;
            $user->save();
            
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 2 
            ]);
            
            $cartItems = $data['cartItems'];
            foreach ($cartItems as $item) 
            {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'count' => $item['count'],
                    'price' => $item['price']
                ]);
            }

            $sum = 0;
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            
            foreach ($orderDetails as $item) 
            {
                $sum += $item->count * $item->price;
            }

            $order = Order::find($order->id);

            if ($order) 
            {
                $order->update([
                    'summa' => $sum
                ]);
            } 
            else 
            {
                return response()->json(['message' => 'Order not found'], 404);
            }

            DB::commit();

            return response()->json([
                'token' => $token,
                'userId' => $user->id,
                'orderId' => $order->id
            ]);
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            Log::error('Ошибка при оформлении заказа: ' . $e->getMessage());
            return response()->json(['error' => 'Ошибка при обработке запроса'], 500);
        }
    }
}
