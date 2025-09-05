<?php

namespace Tests\Feature;

use App\Enums\VehicleUnitType;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    private string $baseUri = self::BASE_API_URI.'/vehicle-assignments';

    private string $authToken;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

        /** @var User $user */
        $this->user = $this->produceUser();
        $this->user->syncRoles(['superadmin']);
    }


    public function test_vehicle_creation(): void
    {

        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        $vehicleData = [
            'plate_number' => $faker->vehicleRegistration(),
            'unit_type' => $faker->randomElement(VehicleUnitType::values()),
            'brand' => $faker->vehicleBrand(),
            'model' => $faker->vehicleModel(),
            'purchase_year' => $faker->year(),
            'model_year' => $faker->year(),
            'chassis_number' => $faker->ean13(),
            'engine_number' => $faker->ean13()
        ];

        $response = $this->actingAs($this->user)->postJson('/api/vehicles', $vehicleData);

        $response->assertCreated();
        $this->assertDatabaseHas('vehicles', $vehicleData);
    }

    public function test_vehicle_search(): void
    {
        $vehicle = Vehicle::factory()->create([
            'plate_number' => 'ABC-123',
            'unit_type' => 'suv',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'purchase_year' => 2020,
            'model_year' => 2020,
            'chassis_number' => '1HGBH41JXMN109186',
            'engine_number' => '2HGBH41JXMN109186'
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/vehicles?query=ABC-123');

        $response->assertOk();
        $this->assertEquals('ABC-123', $response->json()['data'][0]['plate_number']);
    }

    public function test_vehicle_update(): void
    {
        $vehicle = Vehicle::factory()->create();

        $updatedData = [
            'plate_number' => 'XYZ-789',
            'unit_type' => 'suv',
            'brand' => 'Ford',
            'model' => 'F-150',
            'purchase_year' => 2021,
            'model_year' => 2021,
            'chassis_number' => '1HGBH41JXMN109186',
            'engine_number' => '2HGBH41JXMN109186'
        ];

        $response = $this->actingAs($this->user)->putJson("/api/vehicles/{$vehicle->id}", $updatedData);

        $response->assertOk();
        $this->assertDatabaseHas('vehicles', $updatedData);
    }
}
