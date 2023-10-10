<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\HashableService;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => 1,
            'category_id' => HashableService::getHash($this->faker->numberBetween(1, 31), 'Category'),
            'description' => $this->faker->words(6, true),
            'value' => $this->faker->randomFloat(2, 0, 200),
            'date' => $this->faker->dateTimeBetween('-2 months')->format('Y-m-d'),
            'is_computed' => $this->faker->boolean(80),
        ];
    }
}
