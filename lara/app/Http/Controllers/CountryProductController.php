<?php

namespace App\Http\Controllers;
use App\Models\CountryProduct;
use Illuminate\Http\Request;

class CountryProductController extends Controller
{
    public function create(CountryProduct $request)
    {
        $countryProduct = CountryProduct::create($request->all());

        //dd($order);
        return response()->json($countryProduct,201);
    }

    public function item($id)
    {
        //dd($id);
        $countryProduct = CountryProduct::with('countryProducts')->findOrFail($id);
        return response()->json($countryProduct,200);
    }
    public function list(Request $request)
    {
        $countryProduct = CountryProduct::where('id', '>', 2)->paginate(5);
        return response()->json($countryProduct, 200);
    }

    public function update(Request $request, $id)
    {
          $countryProduct = CountryProduct::findOrFail($id);
          $countryProduct -> update($request->all());
          return response()->json($countryProduct, 200);
    }
     public function delete($id)
    {
          $countryProduct = CountryProduct::findOrFail($id);
          $countryProduct->delete();
          return response()->json($countryProduct, 204);
    }
}
