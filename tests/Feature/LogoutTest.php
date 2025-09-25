<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
    }

    public function makeRequest(?string $token)
    {
        $headers = ['Accept' => 'application/json'];
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }
        return $this->delete("/api/auth/logout", [], $headers);
    }

    public function test_should_require_authentication(): void
    {
        $response = $this->makeRequest('');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_should_logout_successfully(): void
    {
        $user = User::first();
        $token = $user->createToken($user->email)->plainTextToken;

        $response = $this->makeRequest($token);
        $response->assertStatus(Response::HTTP_OK);

        $count = DB::table('personal_access_tokens')->count();
        $this->assertEquals(0, $count);
    }
}
