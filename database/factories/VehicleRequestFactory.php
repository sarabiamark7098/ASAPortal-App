<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleRequest>
 */
class VehicleRequestFactory extends Factory
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
            'control_number' => fake()->imei(),
            'purpose' => fake()->sentence(),
            'requested_start' => fake()->date(),
            'requested_end' => fake()->date(),
            'destination' => fake()->sentence(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
