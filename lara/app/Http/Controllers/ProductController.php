<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function create(ProductRequest $request)
    {
        $product = Product::create($request->all());

        //dd($product);
        return response()->json($product,201);
    }

    public function item($id)
    {
        //dd($id);
        $product = Product::with('products')->findOrFail($id);
        return response()->json($product,200);
    }
    public function list(Request $request)
    {
        $product = Product::where('id', '>', 2)->paginate(5);
        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
          $product = Product::findOrFail($id);
          $product -> update($request->all());
          return response()->json($product, 200);
    }
     public function delete($id)
    {
          $product = Product::findOrFail($id);
          $product->delete();
          return response()->json($product, 204);
    }
}
