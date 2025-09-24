<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(int $id)
    {
        $user = User::find($id);
        return $user
            ? $this->okResponse($user)
            : $this->notFoundResponse('Usuário não encontrado');
    }
}
