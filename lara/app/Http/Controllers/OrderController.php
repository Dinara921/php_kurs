<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;

class OrderController extends BaseController
{
    protected $model = Order::class;

    protected function getValidationRules()
    {
         return (new OrderRequest())->rules();
    }

    public function getOrdersForUser($userId)
    {
        $orders = Order::where('user_id', $userId)->get();
        
        $openOrder = $orders->firstWhere('status', 1);

        return response()->json($openOrder);
    }
}
