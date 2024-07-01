<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends BaseController
{
    protected $model = Product::class;

    protected function getValidationRules()
    {
         return (new ProductRequest())->rules();
    }
}
