<?php

namespace App\Http\Controllers;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryProductRequest;

class CategoryProductController extends BaseController
{
    protected $model = CategoryProduct::class;

    protected function getValidationRules()
    {
         return (new CategoryProductRequest())->rules();
    }
}
