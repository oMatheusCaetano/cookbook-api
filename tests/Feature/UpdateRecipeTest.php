<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UpdateRecipeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed --seeder=UserSeeder');
    }

    public function makeRequest(int $id, array $data, $authenticated = true)
    {
        $headers = ['Accept' => 'application/json'];
        if ($authenticated) {
            $user = User::first();
            $headers['Authorization'] = 'Bearer ' . $user->createToken($user->email)->plainTextToken;
        }
        return $this->put("/api/recipe/{$id}", $data, $headers);
    }

    public function test_should_require_authentication(): void
    {
        $response = $this->makeRequest(1, [], false);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_should_return_200_on_valid_data(): void
    {
        $expected = json_decode(file_get_contents(database_path('recipes.json')), true)[0];
        $newName = 'Updated Recipe Name';
        $expected['user_id'] = 1;
        $recipe = Recipe::create($expected);

        $response = $this->makeRequest($recipe->id, array_merge($expected, ['name' => $newName]));
        $response->assertStatus(Response::HTTP_OK);

        $recipe->refresh();
        $this->assertEquals($newName, $recipe->name);
        $this->assertEquals($expected['description'], $recipe->description);
        $this->assertEquals($expected['prep_time'], $recipe->prep_time);
        $this->assertEquals($expected['servings'], $recipe->servings);
    }
}
