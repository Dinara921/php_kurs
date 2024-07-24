<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
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
    
    public function test_successExistCategoryById()
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/category/' . $category->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }
    
    public function test_NotExistCategoryById()
    {
        $category = Category::all()->last();
        //dd($category->id+1);
        $response = $this->get('/api/category/'.$category->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_successExistUpdate()
    {
        $category = Category::factory()->create();

        $updatedData = Category::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/category/' . $category->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_NotExistUpdate()
    {
        $category = Category::factory()->create();

        $updatedData = Category::factory()->make()->toArray();

        $updatedData['name'] = 'STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/category/' . $category->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $category = Category::all()->last();
        $response = $this->delete('/api/category/' . $category->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $category = Category::factory()->create();

        $response = $this->delete('/api/category/' . $category->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_fakeAddCategory()
    {
        $category = Category::factory()->create();

        $response = $this->post('/api/category/', $category->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_createCategoryValidation()
    {
        $category = [
            'name' => '45454545554545454545454454545455445454STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222545454545454554545454554545454545545'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/category', $category);

        $response->assertStatus(422); 
    }

    public function test_getAllCategories()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Category::count();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
