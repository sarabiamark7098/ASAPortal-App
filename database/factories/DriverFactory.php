<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'extension_name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'designation' => fake()->jobTitle(),
            'official_station' => fake()->sentence(),
            'email' => fake()->email(),
            'contact_number' => fake()->phoneNumber(),
        ];
    }
}
