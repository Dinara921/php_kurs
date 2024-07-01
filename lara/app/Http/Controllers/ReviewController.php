<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends BaseController
{
    protected $model = Review::class;

    protected function getValidationRules()
    {
         return (new ReviewRequest())->rules();
    }
}
