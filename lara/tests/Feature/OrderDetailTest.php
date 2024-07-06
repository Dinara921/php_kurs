<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\OrderDetail;

class OrderDetailTest extends TestCase
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

    public function test_successExistOrderDetailById()
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->get('/api/orderDetail/' . $orderDetail->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['products_id', 'count', 'order_id', 'price']);
    }
    
    public function test_NotExistOrderDetailById()
    {
        $orderDetail = OrderDetail::all()->last();
        //dd($orderDetail->id+1);
        $response = $this->get('/api/orderDetail/'.$orderDetail->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['products_id', 'count', 'order_id', 'price']);
    }

    public function test_successExistUpdate()
    {
        $orderDetail = OrderDetail::factory()->create();

        $updatedData = OrderDetail::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/orderDetail/' . $orderDetail->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['products_id', 'count', 'order_id', 'price']);
    }

    public function test_NotExistUpdate()
    {
        $orderDetail = OrderDetail::factory()->create();

        $updatedData = OrderDetail::factory()->make()->toArray();

        $updatedData['count'] = 'lll';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/orderDetail/' . $orderDetail->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $orderDetail = OrderDetail::all()->last();
        $response = $this->delete('/api/orderDetail/' . $orderDetail->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->delete('/api/orderDetail/' . $orderDetail->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('order_details', ['id' => $orderDetail->id]);
    }

    public function test_fakeAddOrderDetail()
    {
        $orderDetail = OrderDetail::factory()->create();

        $response = $this->post('/api/orderDetail/', $orderDetail->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['products_id', 'count', 'order_id', 'price']);
    }

    public function test_createOrderDetailValidation()
    {
        $orderDetail = [
            'count' => 'll'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/orderDetail', $orderDetail);

        $response->assertStatus(422); 
    }

    public function test_getAllOrderDetails()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = OrderDetail::count();

        $response = $this->get('/api/orderDetails');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
