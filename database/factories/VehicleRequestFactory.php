<?php

namespace Database\Factories;

use App\Status;
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
            'requesting_office' => fake()->sentence(),
            'purpose' => fake()->text(),
            'passengers' => fake()->name(),
            'requested_start' => fake()->date(),
            'requested_time' => fake()->time(),
            'requested_end' => fake()->date(),
            'destination' => fake()->text(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
