<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConferenceRequest>
 */
class AssistanceRequestFactory extends Factory
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
            'drn' => fake()->unique()->word(),
            'details' => fake()->text(),
            'request_type' => fake()->randomElements(
                ['Hardware', 'Software', 'Network', 'Others'],
                rand(1, 2)
            ),
            'request_nature' => fake()->randomElements(
                ['Repair', 'Installation', 'Maintenance', 'Configuration'],
                rand(1, 2)
            ),
            'other_type' => fake()->optional()->word(),
            'other_nature' => fake()->optional()->word(),
            'requester_name' => fake()->name(),
            'requester_position' => fake()->jobTitle(),
            'requester_contact_number' => fake()->phoneNumber(),
            'requester_email' => fake()->email(),
        ];
    }
}
