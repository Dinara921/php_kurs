<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    //use RefreshDatabase;

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_Registration()
    {
        $userData = User::factory()->make()->toArray();

        $userData['password'] = 'STEPJJHJHJ12';
        $response = $this->post('/api/register', $userData);

        if ($response->status() !== 201)
        {
            $response->dump();
        }

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', 
        [
            'email' => $userData['email'],
        ]);
    }

    public function test_Login()
    {
         $credentials = $request->only('email', 'password');

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // Генерируем случайный токен и сохраняем его
    $token = Str::random(30);
    $user->token = $token;
    $user->save();

    return response()->json([
        'token' => $token,
        'email' => $user->email,
    ], 200);
    }

    public function test_successExistUserById()
    {
        $user = User::factory()->create();

        $response = $this->get('/api/user/' . $user->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'email', 'name', 'address', 'phone']);
    }
    
    public function test_NotExistUserById()
    {
        $user = User::all()->last();
        //dd($user->id+1);
        $response = $this->get('/api/user/'.$user->id+1);

        $response->assertStatus(404);
        //$response->assertJsonStructure(['id', 'email', 'name', 'address', 'phone', 'token']);
    }

    public function test_successExistUpdate()
    {
        $user = User::factory()->create();

        $updatedData = User::factory()->make()->toArray();
        //dd($updatedData);
        $updatedData['password'] = 'STEP20242';

        $response = $this->put('/api/user/' . $user->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'email', 'name', 'address', 'phone']);
    }

    public function test_NotExistUpdate()
    {
        $user = User::factory()->create();

        $updatedData = User::factory()->make()->toArray();
        //dd($updatedData);
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $response = $this->put('/api/user/' . $user->id, $updatedData);
         
        $response->assertStatus(422); 
    }
   
    public function test_NotExistDelete()
    {
        $user = User::all()->last();
        $response = $this->delete('/api/user/' . $user->id+1);

        $response->assertStatus(404); 
    }

    public function test_successExistDelete()
    {
        $user = User::factory()->create();

        $response = $this->delete('/api/user/' . $user->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_getAllUsers()
    {
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);

        $expectedCount = User::count();

        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response->assertJsonCount($expectedCount);
    }
}

