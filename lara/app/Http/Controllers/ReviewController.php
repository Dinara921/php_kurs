<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
     public function create(ReviewRequest $request)
    {
        $review = Review::create($request->all());

        //dd($review);
        return response()->json($review,201);
    }

    public function item($id)
    {
        //dd($id);
        $review = Review::with('reviews')->findOrFail($id);
        return response()->json($review,200);
    }
    public function list(Request $request)
    {
        $review = User::where('id', '>', 2)->paginate(5);
        return response()->json($review, 200);
    }

    public function update(Request $request, $id)
    {
          $review = Review::findOrFail($id);
          $review -> update($request->all());
          return response()->json($review, 200);
    }
     public function delete($id)
    {
          $review = Review::findOrFail($id);
          $review->delete();
          return response()->json($review, 204);
    }
}
