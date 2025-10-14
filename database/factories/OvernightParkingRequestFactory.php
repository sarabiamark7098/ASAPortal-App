<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OvernightParkingRequest>
 */
class OvernightParkingRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_requested' => fake()->date(),
            'control_number' => fake()->unique()->word(),
            'justification' => fake()->paragraph(),
            'requested_start' => fake()->date(),
            'requested_end' => fake()->date(),
            'requested_time' => fake()->time(),
            'plate_number' => fake()->word(),
            'model' => fake()->word(),
            'office' => fake()->word(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->word(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
            'status' => fake()->randomElement(['pending', 'processed', 'approved', 'disapproved']),
        ];
    }
}
