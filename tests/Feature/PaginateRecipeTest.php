<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PaginateRecipeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
        Artisan::call('db:seed --class=RecipeSeeder');
    }

    public function makeRequest(int $page, int $perPage, $authenticated = true)
    {
        $headers = ['Accept' => 'application/json'];
        if ($authenticated) {
            $user = User::first();
            $headers['Authorization'] = 'Bearer ' . $user->createToken($user->email)->plainTextToken;
        }
        return $this->get("/api/recipe?page={$page}&perPage={$perPage}", $headers);
    }

    public function test_should_require_authentication(): void
    {
        $response = $this->makeRequest(1, 10, false);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_should_return_200(): void
    {
        $response = $this->makeRequest(1, 10);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'current_page',
            'from',
            'last_page',
            'path',
            'per_page',
            'to',
            'total',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'prep_time',
                    'servings',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
