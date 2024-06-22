<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    //use RefreshDatabase;

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_successExistUserById()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->get('/api/user/' . $user->id);

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure(['id', 'login', 'password', 'name', 'address', 'email', 'phone']);
    // }
    
       public function test_successExistUpdate()
    {
        $user = User::factory()->create();

        $updatedData = 
        [
            'name' => 'Updated Name',
            'email' => 'updated_email@example.com',
            'phone' => '1234567890'
        ];

        $this->actingAs($user);

        $response = $this->put('/api/user/' . $user->id, $updatedData);

        $response->assertStatus(200); 
        $response->assertJsonStructure(['id', 'login', 'password', 'name', 'address', 'email', 'phone']);

    }

   
    // public function test_successExistDelete()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->delete('/api/user/' . $user->id);

    //     $response->assertStatus(204); 
    //     $this->assertDatabaseMissing('users', ['id' => $user->id]);
    // }


   public function test_fakeAddUser()
    {
        $faker = \Faker\Factory::create();

        $newUserData = [
            'login' => $faker->unique()->userName,
            'password' => 'pass123',
            'name' => $faker->name,
            'address' => $faker->address,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->numerify('##########'),
        ];

        $response = $this->post('/api/user', $newUserData);

        $response->assertStatus(422); 
        $response->assertJsonValidationErrors(['id', 'login', 'password', 'name', 'address', 'email', 'phone']);

        // Проверяем, что пользователь не был добавлен в базу данных
        $this->assertDatabaseMissing('users', ['email' => $newUserData['email']]);
    }
}

