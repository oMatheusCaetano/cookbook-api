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
            $request->query('per_page', 15),
            $request->query('page', 1)
        );
        return $this->okResponse($recipes);
    }

    public function show(int $id)
    {
        $recipe = $this->repository->find($id);
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
}
