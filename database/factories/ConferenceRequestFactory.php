<?php

namespace Database\Factories;

use App\Enums\ConferenceRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConferenceRequest>
 */
class ConferenceRequestFactory extends Factory
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
            'number_of_persons' => fake()->numberBetween(1, 100),
            'requested_start' => fake()->date(),
            'requested_time_start' => fake()->time(),
            'requested_end' => fake()->date(),
            'requested_time_end' => fake()->time(),
            'focal' => fake()->name(),
            'conference_room' => fake()->randomElement(ConferenceRoom::values()),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
