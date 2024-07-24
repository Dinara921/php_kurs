<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends BaseController
{
    protected $model = Category::class;

    protected function getValidationRules()
    {
         return (new CategoryRequest())->rules();
    }
}
