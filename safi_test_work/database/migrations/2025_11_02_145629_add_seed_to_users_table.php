<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function down(): void
    {
        User::whereEmail('test@test.com')->delete();
    }
};
