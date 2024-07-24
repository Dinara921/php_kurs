<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Country;


class CountryTest extends TestCase
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

    public function test_successExistCountryById()
    {
        $country = Country::factory()->create();

        $response = $this->get('/api/country/' . $country->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name']);
    }
    
    public function test_NotExistCountryById()
    {
        $country = Country::all()->last();
        //dd($countryProduct->id+1);
        $response = $this->get('/api/country/'.$country->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'name']);
    }

    public function test_successExistUpdate()
    {
        $country = Country::factory()->create();

        $updatedData = Country::factory()->make()->toArray();
        //dd($updatedData);

        $response = $this->put('/api/country/' . $country->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'name']);
    }

    public function test_NotExistUpdate()
    {
        $country = Country::factory()->create();

        $updatedData = Country::factory()->make()->toArray();

        $updatedData['name'] = 'STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222';
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/country/' . $country->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $country = Country::all()->last();
        $response = $this->delete('/api/country/' . $country->id+100);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $country = Country::factory()->create();

        $response = $this->delete('/api/country/' . $country->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('countries', ['id' => $country->id]);
    }

    public function test_fakeAddCountry()
    {
        $country = Country::factory()->create();

        $response = $this->post('/api/country/', $country->toArray());

        if ($response->status() === 302) 
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name']);
    }

    public function test_createCountryValidation()
    {
        $countryData = [
            'name' => '45454545554545454545454454545455445454STEP20246555555555555555555555555555555555555555555555555555555555555555555555522222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222545454545454554545454554545454545545'
        ];

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        
        $response = $this->post('/api/country', $countryData);

        $response->assertStatus(422); 
    }

    public function test_getAllCountries()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = Country::count();

        $response = $this->get('/api/countries');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}
