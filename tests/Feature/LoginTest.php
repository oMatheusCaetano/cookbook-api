<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function makeRequest(array $data = []): \Illuminate\Testing\TestResponse
    {
        return $this->post('/api/auth/login', $data, [
            'Accept' => 'application/json',
        ]);
    }

    public function test_validates_request_data(): void
    {
        $response = $this->makeRequest();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
