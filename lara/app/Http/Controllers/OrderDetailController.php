<?php

namespace App\Http\Controllers;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderDetailRequest;

class OrderDetailController extends BaseController
{
    protected $model = OrderDetail::class;

    protected function getValidationRules()
    {
         return (new OrderDetailRequest())->rules();
    }

    public function getOrderDetailsByOrderId($orderId)
    {
       try {
            $orderDetails = OrderDetail::where('order_id', $orderId)
                ->with('product')  
                ->get();

            $result = $orderDetails->map(function ($orderDetail) 
            {
                return [
                    'id' => $orderDetail->id,
                    'product_id' => $orderDetail->product_id,
                    'count' => $orderDetail->count,
                    'price' => $orderDetail->price,
                    'product_name' => $orderDetail->product ? $orderDetail->product->name : 'Неизвестный продукт',
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkOnly(OrderDetailRequest $request)
    {
        $validated = $request->validated();

        $orderDetail = OrderDetail::where('order_id', $validated['order_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        \Log::info('OrderDetail found, updating:', [
            'order_id' => $validated['order_id'], 
            'product_id' => $validated['product_id']
        ]);

        if ($orderDetail) 
        {
            $orderDetail->update([
                'count' => $validated['count'],
                'price' => $validated['price'],
            ]);
        } 
        else 
        {
            $orderDetail = OrderDetail::create($validated);
        } 

        $sum = 0;
        $orderDetails = OrderDetail::where('order_id', $validated['order_id'])->get();
        
        foreach ($orderDetails as $item) 
        {
            $sum += $item->count * $item->price;
        }

        $order = Order::find($validated['order_id']);

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

        return response()->json(['message' => 'Order detail updated', 'data' => $orderDetail]);  
    }


    public function reduceProductQuantities($orderId)
    {
        try 
        {
            $orderDetails = OrderDetail::where('order_id', $orderId)->get();

            foreach ($orderDetails as $detail) 
            {
                $product = Product::find($detail->product_id);
                if ($product) 
                {
                    $product->count -= $detail->count;
                    $product->count = max($product->count, 0);                 
                    $product->save();
                } 
                else 
                {
                    return response()->json(['error' => 'Продукт не найден'], 404);
                }
            }

            return response()->json(['message' => 'Количество товаров обновлено успешно']);
        } 
        catch (\Exception $e) 
        {
            \Log::error('Ошибка при уменьшении количества товаров: ' . $e->getMessage());
            return response()->json(['error' => 'Внутренняя ошибка сервера'], 500);
        }
    }
}
