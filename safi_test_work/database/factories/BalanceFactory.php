<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Balance>
 */
class BalanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::select('id')->first()->id,
            'balance' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
