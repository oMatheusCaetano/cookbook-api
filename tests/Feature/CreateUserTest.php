<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function makeRequest(array $data)
    {
        return $this->post("/api/user", $data, ['Accept' => 'application/json']);
    }

    public function test_should_not_allow_duplicate_email(): void
    {
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
        $existingUser = User::first();
        $data = [
            'name' => 'New User',
            'email' => $existingUser->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $response = $this->makeRequest($data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_should_return_201_on_valid_data(): void
    {
        Artisan::call('migrate:fresh');
        $data = [
            'name' => 'New User',
            'email' => 'newuser@email.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $response = $this->makeRequest($data);
        $response->assertStatus(Response::HTTP_CREATED);
        $user = User::where('email', $data['email'])->first();
        $this->assertNotNull($user);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
    }
}
