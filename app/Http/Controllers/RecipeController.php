<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecipeRequest;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    private RecipeRepository $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        $recipes = $this->repository->paginate(
            perPage: $request->query('per_page', 15),
            page: $request->query('page', 1),
            with: $this->withes()
        );
        return $this->okResponse($recipes);
    }

    public function show(int $id, Request $request)
    {
        $recipe = $this->repository->find(id: $id, with: $this->withes());
        return $recipe
            ? $this->okResponse($recipe)
            : $this->notFoundResponse('Receita não encontrada');
    }

    public function store(CreateRecipeRequest $request)
    {
        $payload = $request->validated();
        $recipe = $this->repository->create($payload);
        return $this->createdResponse($recipe);
    }

    public function update(int $id, CreateRecipeRequest $request)
    {
        $payload = $request->validated();
        $recipe = $this->repository->update($id, $payload);
        return $this->okResponse($recipe);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return $this->messageResponse('Receita deletada com sucesso!');
    }

    private function withes()
    {
        $whites = request()->query('with', null);

        if (!$whites) {
            return null;
        }

        return explode(',', $whites) ?? null;
    }
}
