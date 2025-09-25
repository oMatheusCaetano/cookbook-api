<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->repository->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->invalidCredentialsResponse();
        }

        $token = $user->createToken($user->email);
        return $this->okResponse([ 'user' => $user, 'token' => $token->plainTextToken ]);
    }

    public function logout()
    {

        Auth::user()->tokens()->forceDelete();
        return $this->okResponse(['message' => 'Logged out successfully']);
    }
}
