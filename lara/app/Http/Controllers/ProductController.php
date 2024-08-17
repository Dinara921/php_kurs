<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    protected $model = Product::class;

    protected function getValidationRules()
    {
         return (new ProductRequest())->rules();
    }

    public function create(Request $request)
    {
        $rules = (new ProductRequest())->rules();
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('file')) 
        {
            $file_name = Storage::disk('public')->put('uploads', $request->file('file'));
            $data['img'] = $file_name;
        }

        $item = $this->model::create($data);

        return response()->json($item, 201);
    }
}
