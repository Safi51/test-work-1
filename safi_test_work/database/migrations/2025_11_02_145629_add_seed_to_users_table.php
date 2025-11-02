<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        User::insert([
            [
                'name' => 'Test1',
                'email' => 'test1@test.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Test2',
                'email' => 'test2@test.com',
                'password' => Hash::make('password'),
            ]
        ]);
    }

    public function down(): void
    {

    }
};
