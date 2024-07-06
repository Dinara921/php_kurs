<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;


class ProductTest extends TestCase
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

    public function test_successExistProductById()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/product/' . $product->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'category_id', 'country_id', 'img', 'sale_id', 'count', 'price']);
    }
    
    public function test_NotExistProductById()
    {
        $product = Product::all()->last();
        //dd($sale->id+1);
        $response = $this->get('/api/product/'.$product->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name', 'category_id', 'country_id', 'img', 'sale_id', 'count', 'price']);
    }

    public function test_successExistUpdate()
    {
        $product = Product::factory()->create();

        $updatedData = Product::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/product/' . $product->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name', 'category_id', 'country_id', 'img', 'sale_id', 'count', 'price']);
    }

    public function test_NotExistUpdate()
    {
        $product = Product::factory()->create();

        $updatedData = Product::factory()->make()->toArray();

        $updatedData['name'] = 'ss';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/product/' . $product->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $product = Product::all()->last();
        $response = $this->delete('/api/product/' . $product->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $product = Product::factory()->create();

        $response = $this->delete('/api/product/' . $product->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_fakeAddSale()
    {
        $product = Product::factory()->create();

        $response = $this->post('/api/product/', $product->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'category_id', 'country_id', 'img', 'sale_id', 'count', 'price']);
    }

    public function test_createProductValidation()
    {
        $product = [
            'name' => 'a'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/sale', $product);

        $response->assertStatus(422); 
    }

    public function test_getAllProduct()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Product::count();

        $response = $this->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
