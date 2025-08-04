<?php

namespace Database\Factories;

use App\Enums\VehicleUnitType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plate_number' => fake()->ean13(),
            'unit_type' => fake()->randomElement(VehicleUnitType::values()),
            'brand' => fake()->name(),
            'model' => fake()->name(),
            'purchase_year' => fake()->year(),
            'model_year' => fake()->year(),
            'engine_number' => fake()->ean13(),
            'chasis_number' => fake()->ean13(),
        ];
    }
}
