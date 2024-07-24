<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;

class CountryController extends BaseController
{
    protected $model = Country::class;

    protected function getValidationRules()
    {
         return (new CountryRequest())->rules();
    }
}
