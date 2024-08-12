<?php

namespace App\Http\Controllers;
use App\Models\OrderDetail;
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
                ->with('product')  // Загрузка данных продукта
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
        // Валидация запроса
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'count' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        // Поиск существующей записи
        $orderDetail = OrderDetail::where('order_id', $validated['order_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($orderDetail) 
        {
            // Логирование для отладки
            \Log::info('OrderDetail found, updating:', ['order_id' => $validated['order_id'], 'product_id' => $validated['product_id']]);

            // Обновление существующей записи
            $orderDetail->update([
                'count' => $validated['count'],
                'price' => $validated['price'],
            ]);

            return response()->json(['message' => 'Order detail updated', 'data' => $orderDetail]);
        } 
        else 
        {
            // Логирование для отладки
            \Log::info('OrderDetail not found, creating:', ['order_id' => $validated['order_id'], 'product_id' => $validated['product_id']]);

            // Создание новой записи
            $orderDetail = OrderDetail::create($validated);

            return response()->json(['message' => 'Order detail created', 'data' => $orderDetail]);
        }
    }
}
