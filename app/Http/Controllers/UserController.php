<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(int $id)
    {
        $user = $this->repository->find($id);
        return $user
            ? $this->okResponse($user)
            : $this->notFoundResponse('Usuário não encontrado');
    }

    public function store(CreateUserRequest $request)
    {
        $payload = $request->validated();
        $recipe = $this->repository->create($payload);
        return $this->createdResponse($recipe);
    }
}
