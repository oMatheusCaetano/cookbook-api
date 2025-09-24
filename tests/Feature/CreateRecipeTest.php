<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateRecipeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
    }

    public function makeRequest(array $data, $authenticated = true)
    {
        $headers = ['Accept' => 'application/json'];
        if ($authenticated) {
            $user = User::first();
            $headers['Authorization'] = 'Bearer ' . $user->createToken($user->email)->plainTextToken;
        }
        return $this->post("/api/recipe", $data, $headers);
    }

    public function test_should_require_authentication(): void
    {
        $response = $this->makeRequest([], false);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    public function test_should_return_201_on_valid_data(): void
    {
        $expected = json_decode(file_get_contents(database_path('recipes.json')), true)[0];
        $response = $this->makeRequest($expected);
        $response->assertStatus(Response::HTTP_CREATED);
        $recipe = Recipe::with('ingredients', 'steps')->where('name', $expected['name'])->first();
        $this->assertNotNull($recipe);
        $this->assertEquals($expected['name'], $recipe->name);
        $this->assertEquals($expected['description'], $recipe->description);
        $this->assertEquals($expected['prep_time'], $recipe->prep_time);
        $this->assertEquals($expected['servings'], $recipe->servings);
    }
}
