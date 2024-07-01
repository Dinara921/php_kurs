<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CountryProduct;


class CountryProductTest extends TestCase
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

    public function test_successExistCountryProductById()
    {
        $countryProduct = CountryProduct::factory()->create();

        $response = $this->get('/api/countryProduct/' . $countryProduct->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name']);
    }
    
    public function test_NotExistCountryProductById()
    {
        $countryProduct = CountryProduct::all()->last();
        //dd($countryProduct->id+1);
        $response = $this->get('/api/countryProduct/'.$countryProduct->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name']);
    }

    public function test_successExistUpdate()
    {
        $countryProduct = CountryProduct::factory()->create();

        $updatedData = CountryProduct::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/countryProduct/' . $countryProduct->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name']);
    }

    public function test_NotExistUpdate()
    {
        $countryProduct = CountryProduct::factory()->create();

        $updatedData = CountryProduct::factory()->make()->toArray();

        $updatedData['name'] = 'STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/countryProduct/' . $countryProduct->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $countryProduct = CountryProduct::all()->last();
        $response = $this->delete('/api/countryProduct/' . $countryProduct->id+1);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $countryProduct = CountryProduct::factory()->create();

        $response = $this->delete('/api/countryProduct/' . $countryProduct->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('country_products', ['id' => $countryProduct->id]);
    }

    public function test_fakeAddCountryProduct()
    {
        $countryProduct = CountryProduct::factory()->create();

        $response = $this->post('/api/countryProduct/', $countryProduct->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name']);
    }

    public function test_createCountryProductValidation()
    {
        $countryProductData = [
            'name' => '45454545554545454545454454545455445454STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222545454545454554545454554545454545545'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/countryProduct', $countryProductData);

        $response->assertStatus(422); 
    }

    public function test_getAllCountryProducts()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = CountryProduct::count();

        $response = $this->get('/api/countryProducts');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
