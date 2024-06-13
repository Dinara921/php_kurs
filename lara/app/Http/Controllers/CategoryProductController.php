<?php

namespace App\Http\Controllers;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
      public function create(CategoryProduct $request)
    {
        $categoryProduct = CategoryProduct::create($request->all());

        //dd($order);
        return response()->json($categoryProduct,201);
    }

    public function item($id)
    {
        //dd($id);
        $categoryProduct = CategoryProduct::with('categoryProducts')->findOrFail($id);
        return response()->json($categoryProduct,200);
    }
    public function list(Request $request)
    {
        $categoryProduct = CategoryProduct::where('id', '>', 2)->paginate(5);
        return response()->json($categoryProduct, 200);
    }

    public function update(Request $request, $id)
    {
          $categoryProduct = CategoryProduct::findOrFail($id);
          $categoryProduct -> update($request->all());
          return response()->json($categoryProduct, 200);
    }
     public function delete($id)
    {
          $categoryProduct = CategoryProduct::findOrFail($id);
          $categoryProduct->delete();
          return response()->json($categoryProduct, 204);
    }
}
