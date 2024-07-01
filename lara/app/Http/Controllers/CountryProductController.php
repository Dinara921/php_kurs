<?php

namespace App\Http\Controllers;
use App\Models\CountryProduct;
use Illuminate\Http\Request;
use App\Http\Requests\CountryProductRequest;

class CountryProductController extends BaseController
{
    protected $model = CountryProduct::class;

    protected function getValidationRules()
    {
         return (new CountryProductRequest())->rules();
    }
}
