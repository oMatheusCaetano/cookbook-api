<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function makeRequest(array $data = []): \Illuminate\Testing\TestResponse
    {
        return $this->post('/api/auth/login', $data, [
            'Accept' => 'application/json',
        ]);
    }

    public function test_should_validate_request_data(): void
    {
        $response = $this->makeRequest();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_should_return_invalid_credentials_error(): void
    {
        Artisan::call('migrate:fresh');
        $payload = [ 'email' => 'testinvalidemail@testinvalidemail.com', 'password' => 'invalidpassword' ];
        $response = $this->makeRequest($payload);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonFragment([ 'message' => 'Credenciais inválidas' ]);
    }

    public function test_should_login_successfully(): void
    {
        Artisan::call('migrate:fresh');
        $payload = [ 'email' => 'usuarioteste@email.com', 'password' => '123456789' ];
        $response = $this->makeRequest($payload);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
