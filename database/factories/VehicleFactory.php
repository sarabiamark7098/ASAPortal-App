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

        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        return [
            'plate_number' => $faker->vehicleRegistration(),
            'unit_type' => fake()->randomElement(VehicleUnitType::values()),
            'brand' => $faker->vehicleBrand(),
            'model' => $faker->vehicleModel(),
            'purchase_year' => fake()->year(),
            'model_year' => fake()->year(),
            'engine_number' => fake()->ean13(),
            'chasis_number' => fake()->ean13(),
        ];
    }
}
