<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');
            $table->foreignId('to_user_id')
                ->constrained('users')
                ->onDelete('restrict');
            $table->float('amount', 2);
            $table->enum('type', ['deposit', 'withdraw', 'transfer_in', 'transfer_out']);
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
