<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleAssignmentTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_it_can_fetch_vehicle_assignments(): void
    {
        $count = 10;
        $this->produceVehicleAssignment($count);

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_creation_of_vehicle_assignment(): void
    {
        $vehicle = Vehicle::factory()->create();
        $driver = Driver::factory()->create();

        $payload = [
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
        ];

        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('vehicle_assignments', $payload);
    }

}
