<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
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
          'name' => $this->faker->name,
          'color' => $this->faker->colorName,
          'icon' => $this->faker->word,
          'description' => $this->faker->text(255)
        ];
    }
}
