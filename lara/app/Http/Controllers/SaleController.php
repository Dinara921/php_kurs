<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Models\Sale;

class SaleController extends Controller
{
     public function create(SaleRequest $request)
    {
        $sale = Sale::create($request->all());

        //dd($sale);
        return response()->json($sale,201);
    }

    public function item($id)
    {
        //dd($id);
        $sale = Sale::with('sales')->findOrFail($id);
        return response()->json($sale,200);
    }
    public function list(Request $request)
    {
        $sale = Sale::where('id', '>', 2)->paginate(5);
        return response()->json($sale, 200);
    }

    public function update(Request $request, $id)
    {
          $sale = Sale::findOrFail($id);
          $sale -> update($request->all());
          return response()->json($sale, 200);
    }
     public function delete($id)
    {
          $sale = Sale::findOrFail($id);
          $sale->delete();
          return response()->json($sale, 204);
    }
}
