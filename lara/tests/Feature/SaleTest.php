<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;

class SaleTest extends TestCase
{
    //use RefreshDatabase;
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
    
    public function test_successExistSaleById()
    {
        $sale = Sale::factory()->create();

        $response = $this->get('/api/sale/' . $sale->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'discount', 'expired_at']);
    }
    
    public function test_NotExistSaleById()
    {
        $sale = Sale::all()->last();
        //dd($sale->id+1);
        $response = $this->get('/api/sale/'.$sale->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name', 'discount', 'expired_at']);
    }

    public function test_successExistUpdate()
    {
        $sale = Sale::factory()->create();

        $updatedData = Sale::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/sale/' . $sale->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name', 'discount', 'expired_at']);
    }

    public function test_NotExistUpdate()
    {
        $sale = Sale::factory()->create();

        $updatedData = Sale::factory()->make()->toArray();

        $updatedData['name'] = 'ss';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/sale/' . $sale->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $sale = Sale::all()->last();
        $response = $this->delete('/api/sale/' . $sale->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $sale = Sale::factory()->create();

        $response = $this->delete('/api/sale/' . $sale->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('sales', ['id' => $sale->id]);
    }

    public function test_fakeAddSale()
    {
        $sale = Sale::factory()->create();

        $response = $this->post('/api/sale/', $sale->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'discount', 'expired_at']);
    }

    public function test_createSaleValidation()
    {
        $sale = [
            'name' => 'a'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/sale', $sale);

        $response->assertStatus(422); 
    }

    public function test_getAllSales()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Sale::count();

        $response = $this->get('/api/sales');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
