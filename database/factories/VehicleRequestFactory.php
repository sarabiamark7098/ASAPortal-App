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
            'requesting_office' => fake()->company(),
            'control_number' => fake()->imei(),
            'purpose' => fake()->sentence(),
            'passengers' => fake()->words(3, true),
            'requested_start' => fake()->date(),
            'requested_time' => fake()->time('H:i:s'),
            'requested_end' => fake()->date(),
            'destination' => fake()->sentence(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
