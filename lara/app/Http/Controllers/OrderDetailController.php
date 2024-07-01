<?php

namespace App\Http\Controllers;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Requests\OrderDetailRequest;

class OrderDetailController extends BaseController
{
    protected $model = OrderDetail::class;

    protected function getValidationRules()
    {
         return (new OrderDetailRequest())->rules();
    }
}
