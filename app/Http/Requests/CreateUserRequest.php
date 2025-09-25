<?php

namespace App\Http\Requests;

class CreateUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string|min:2|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ];
    }
}
