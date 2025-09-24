<?php

namespace App\Http\Requests;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
