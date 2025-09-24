<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FindUserTest extends TestCase
{
    public function makeRequest(int $id): \Illuminate\Testing\TestResponse
    {
        return $this->get("/api/user/{$id}", [
            'Accept' => 'application/json',
        ]);
    }

    public function test_should_return_404_on_invalid_id(): void
    {
        Artisan::call('migrate:fresh');
        $response = $this->makeRequest(1234567890);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJsonFragment([ 'message' => 'Usuário não encontrado' ]);
    }

    public function test_should_return_200_on_valid_id(): void
    {
        Artisan::call('migrate:fresh');
        $user = User::find(1);
        $response = $this->makeRequest(1);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }
}
