<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormFlight>
 */
class FormFlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destination_from' => fake()->text(),
            'destination_to' => fake()->text(),
            'departure_date' => fake()->date(),
            'trip_mode' => fake()->randomElement(['Depart', 'Return']),
            'etd' => fake()->time(),
            'eta' => fake()->time(),
        ];
    }
}
