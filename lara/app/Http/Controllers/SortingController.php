<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Product; 
use Illuminate\Http\Request;

class SortingController extends Controller
{
    public function sortingAscName()
    {
        $items = Product::orderBy('name', 'asc')->get();
        return response()->json($items);
    }

    public function sortingDescName()
    {
        $items = Product::orderBy('name', 'desc')->get();
        return response()->json($items);
    }

    public function sortingAscPrice()
    {
        $items = Product::orderBy('price', 'asc')->get();
        return response()->json($items);
    }

    public function sortingDescPrice()
    {
        $items = Product::orderBy('price', 'desc')->get();
        return response()->json($items);
    }
}
