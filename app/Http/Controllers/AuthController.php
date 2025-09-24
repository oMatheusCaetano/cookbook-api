<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->invalidCredentialsResponse();
        }

        $token = $user->createToken($user->email);
        return $this->okResponse([ 'user' => $user, 'token' => $token->plainTextToken ]);
    }
}
