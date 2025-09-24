<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Usuário teste',
            'email'    => 'usuarioteste@email.com',
            'password' =>  '123456789'
        ]);
    }
}
