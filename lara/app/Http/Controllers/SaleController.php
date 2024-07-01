<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Models\Sale;

class SaleController extends BaseController
{
    protected $model = Sale::class;

    protected function getValidationRules()
    {
         return (new SaleRequest())->rules();
    }
}
