<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JanitorialRequest>
 */
class JanitorialRequestFactory extends Factory
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
            'count_utility' => fake()->numberBetween(1, 100),
            'requested_date' => fake()->date(),
            'requested_time' => fake()->time(),
            'location' => fake()->address(),
            'fund_source' => fake()->sentence(),
            'office_head' => fake()->name(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
