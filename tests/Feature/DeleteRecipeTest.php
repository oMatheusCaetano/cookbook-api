<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DeleteRecipeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
        Artisan::call('db:seed --class=RecipeSeeder');
    }

    public function makeRequest(int $id, $authenticated = true)
    {
        $headers = ['Accept' => 'application/json'];
        if ($authenticated) {
            $user = User::first();
            $headers['Authorization'] = 'Bearer ' . $user->createToken($user->email)->plainTextToken;
        }
        return $this->delete("/api/recipe/{$id}", [], $headers);
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
        $id = Recipe::find(1)->id;
        $response = $this->makeRequest($id);
        $response->assertStatus(Response::HTTP_OK);
        $recipe = Recipe::find($id);
        $this->assertNull($recipe);
    }
}
