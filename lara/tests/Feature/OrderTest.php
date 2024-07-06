<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
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

    public function test_successExistOrderById()
    {
        $order = Order::factory()->create();

        $response = $this->get('/api/order/' . $order->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'status', 'users_id', 'summa']);
    }
    
    public function test_NotExistOrderById()
    {
        $order = Order::all()->last();
        //dd($order->id+1);
        $response = $this->get('/api/order/'.$order->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'status', 'users_id', 'summa']);
    }

    public function test_successExistUpdate()
    {
        $order = Order::factory()->create();

        $updatedData = Order::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/order/' . $order->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'status', 'users_id', 'summa']);
    }

    public function test_NotExistUpdate()
    {
        $order = Order::factory()->create();

        $updatedData = Order::factory()->make()->toArray();

        $updatedData['status'] = '22';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/order/' . $order->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $order = Order::all()->last();
        $response = $this->delete('/api/order/' . $order->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $order = Order::factory()->create();

        $response = $this->delete('/api/order/' . $order->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }

    public function test_fakeAddOrder()
    {
        $order = Order::factory()->create();

        $response = $this->post('/api/order/', $order->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'status', 'users_id', 'summa']);
    }

    public function test_createOrderValidation()
    {
        $order = [
            'status' => '22'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/order', $order);

        $response->assertStatus(422); 
    }

    public function test_getAllOrders()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Order::count();

        $response = $this->get('/api/orders');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
