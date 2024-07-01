<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CategoryProduct;

class CategoryProductTest extends TestCase
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
     public function test_successExistCategoryProductById()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->get('/api/categoryProduct/' . $categoryProduct->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }
    
    public function test_NotExistCategoryProductById()
    {
        $categoryProduct = CategoryProduct::all()->last();
        //dd($categoryProduct->id+1);
        $response = $this->get('/api/categoryProduct/'.$categoryProduct->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_successExistUpdate()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $updatedData = CategoryProduct::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/categoryProduct/' . $categoryProduct->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_NotExistUpdate()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $updatedData = CategoryProduct::factory()->make()->toArray();

        $updatedData['name'] = 'STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/categoryProduct/' . $categoryProduct->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $categoryProduct = CategoryProduct::all()->last();
        $response = $this->delete('/api/countryProduct/' . $categoryProduct->id+1);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->delete('/api/categoryProduct/' . $categoryProduct->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('category_products', ['id' => $categoryProduct->id]);
    }

    public function test_fakeAddCategoryProduct()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->post('/api/categoryProduct/', $categoryProduct->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'category_id']);
    }

    public function test_createCategoryProductValidation()
    {
        $categoryProduct = [
            'name' => '45454545554545454545454454545455445454STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222545454545454554545454554545454545545'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/categoryProduct', $categoryProduct);

        $response->assertStatus(422); 
    }

    public function test_getAllCategoryProducts()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = CategoryProduct::count();

        $response = $this->get('/api/categoryProducts');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
