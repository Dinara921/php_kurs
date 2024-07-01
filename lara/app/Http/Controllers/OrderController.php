<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;

class OrderController extends BaseController
{
    protected $model = Order::class;

    protected function getValidationRules()
    {
         return (new OrderRequest())->rules();
    }
}
