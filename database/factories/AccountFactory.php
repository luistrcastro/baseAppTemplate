<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'label' => $this->faker->word(),
            'description' => $this->faker->words(6, true),
            'last_four' => $this->faker->randomNumber(4),
            'institution' => $this->faker->word(),
        ];
    }
}
