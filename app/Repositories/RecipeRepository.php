<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipeRepository
{
    public function paginate(
        int $perPage = 15,
        int $page = 1,
    )
    {
        return Recipe::paginate(perPage: $perPage, page: $page);
    }

    public function find(int $id): ?Recipe
    {
        return Recipe::find($id);
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $recipe = Recipe::findOrFail($id);
            $recipe->ingredients()->delete();
            $recipe->steps()->delete();
            $recipe->delete();
        });
    }

    public function create(array $data): Recipe
    {
        return DB::transaction(function () use ($data) {
            $recipe = Recipe::create($data);
            $this->syncRelations($recipe, $data);
            return $recipe;
        });
    }

    public function update(int $id, array $data): Recipe
    {
        return DB::transaction(function () use ($id, $data) {
            $recipe = Recipe::findOrFail($id);
            $recipe->update($data);
            $this->syncRelations($recipe, $data);
            return $recipe;
        });
    }

    private function syncRelations(Recipe $recipe, array $data): void
    {
        $this->syncRelation($recipe, 'ingredients', $data['ingredients']);
        $this->syncRelation($recipe, 'steps',       $data['steps']);
    }

    private function syncRelation(Recipe $recipe, string $relation, $items): void
    {
        if (!$items && !is_array($items)) {
            return;
        }

        $ids = [];
        foreach ($items as $item) {
            $model = $recipe->{$relation}()->updateOrCreate(['id' => $item['id'] ?? null], $item);
            $ids[] = $model->id;
        }

        $recipe->{$relation}()->whereNotIn('id', $ids)->delete();
    }
}
