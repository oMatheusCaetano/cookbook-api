<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipesJson = json_decode(file_get_contents(database_path('recipes.json')), true);

        foreach ($recipesJson as $recipeData) {
            $recipe = Recipe::create([
                'name'        => $recipeData['name'],
                'description' => $recipeData['description'],
                'prep_time'   => $recipeData['prep_time'],
                'servings'    => $recipeData['servings'],
            ]);

            if (isset($recipeData['ingredients'])) {
                $recipe->ingredients()->createMany($recipeData['ingredients']);
            }

            if (isset($recipeData['steps'])) {
                $recipe->steps()->createMany($recipeData['steps']);
            }
        }
    }
}
