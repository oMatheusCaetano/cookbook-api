<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        User::create([
            'name'     => 'Usuário teste',
            'email'    => 'usuarioteste@email.com',
            'password' =>  '123456789'
        ]);
    }

    public function down(): void
    {
        User::where('email', 'usuarioteste@email.com')->delete();
    }
};
