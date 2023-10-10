<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstName = $this->faker->name;
        $lastName = $this->faker->name;
        return [
            'first_name' => $firstName,
            'middle_name' => $this->faker->name,
            'last_name' => $lastName,
            'full_name' => $firstName . ' ' . $lastName,
            'email' => $this->faker->safeEmail,
            'email_verified_at' => now(),
            'receives_browser_notifications' => true,
            'receives_email_notifications' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
