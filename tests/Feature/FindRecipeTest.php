<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FindRecipeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
    }

    public function makeRequest(int $id, $authenticated = true): \Illuminate\Testing\TestResponse
    {
        $headers = ['Accept' => 'application/json'];
        if ($authenticated) {
            $user = User::first();
            $headers['Authorization'] = 'Bearer ' . $user->createToken($user->email)->plainTextToken;
        }
        return $this->get("/api/recipe/{$id}?with=user,ingredients,steps", $headers);
    }

    public function test_should_require_authentication(): void
    {
        $response = $this->makeRequest(1, false);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_should_return_404_on_invalid_id(): void
    {
        $response = $this->makeRequest(99999);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_should_return_200_on_valid_id(): void
    {
        Artisan::call('db:seed --class=RecipeSeeder');
        $recipe = Recipe::first();
        $response = $this->makeRequest($recipe->id);
        $response->assertStatus(Response::HTTP_OK);
    }
}
