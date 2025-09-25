<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find(int $id, $with = [])
    {
        return User::with($with ?? [])->find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }
}
