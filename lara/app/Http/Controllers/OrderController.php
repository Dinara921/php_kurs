<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Order $request)
    {
        $order = Order::create($request->all());

        //dd($order);
        return response()->json($order,201);
    }

    public function item($id)
    {
        //dd($id);
        $order = Order::with('orders')->findOrFail($id);
        return response()->json($order,200);
    }
    public function list(Request $request)
    {
        $order = Order::where('id', '>', 2)->paginate(5);
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
          $order = Order::findOrFail($id);
          $order -> update($request->all());
          return response()->json($order, 200);
    }
     public function delete($id)
    {
          $order = Order::findOrFail($id);
          $order->delete();
          return response()->json($order, 204);
    }
}
