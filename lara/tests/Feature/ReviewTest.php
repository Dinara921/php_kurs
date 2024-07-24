<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Review;

class ReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
     public function test_successExistReviewById()
    {
        $review = Review::factory()->create();

        $response = $this->get('/api/review/' . $review->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['product_id', 'user_id', 'order_id', 'text', 'grade']);
    }
    
    public function test_NotExistReviewById()
    {
        $review = Review::all()->last();
        //dd($review->id+1);
        $response = $this->get('/api/review/'.$review->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['product_id', 'user_id', 'order_id', 'text', 'grade']);
    }

    public function test_successExistUpdate()
    {
        $review = Review::factory()->create();

        $updatedData = Review::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/review/' . $review->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['product_id', 'user_id', 'order_id', 'text', 'grade']);
    }

    public function test_NotExistUpdate()
    {
        $review = Review::factory()->create();

        $updatedData = Review::factory()->make()->toArray();

        $updatedData['grade'] = 8;
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/review/' . $review->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $review = Review::all()->last();
        $response = $this->delete('/api/review/' . $review->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $review = Review::factory()->create();

        $response = $this->delete('/api/review/' . $review->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_fakeAddReview()
    {
        $review = Review::factory()->create();

        $response = $this->post('/api/review/', $review->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['product_id', 'user_id', 'order_id', 'text', 'grade']);
    }

    public function test_createReviewValidation()
    {
        $review = [
            'count' => 'll'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/review', $review);

        $response->assertStatus(422); 
    }

    public function test_getAllReview()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Review::count();

        $response = $this->get('/api/reviews');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
