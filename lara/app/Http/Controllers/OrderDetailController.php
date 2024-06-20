<?php

namespace App\Http\Controllers;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Requests\OrderDetailRequest;

class OrderDetailController extends Controller
{
    public function create(OrderDetailRequest $request)
    {
        $orderDetail = OrderDetail::create($request->all());

        //dd($orderDetail);
        return response()->json($orderDetail,201);
    }

    public function item($id)
    {
        //dd($id);
        $orderDetail = OrderDetail::with('orderDetails')->findOrFail($id);
        return response()->json($orderDetail,200);
    }
    public function list(Request $request)
    {
        $orderDetail = OrderDetail::where('id', '>', 2)->paginate(5);
        return response()->json($orderDetail, 200);
    }

    public function update(Request $request, $id)
    {
          $orderDetail = OrderDetail::findOrFail($id);
          $orderDetail -> update($request->all());
          return response()->json($orderDetail, 200);
    }
     public function delete($id)
    {
          $orderDetail = OrderDetail::findOrFail($id);
          $orderDetail->delete();
          return response()->json($orderDetail, 204);
    }
}
