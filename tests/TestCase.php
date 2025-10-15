<?php

namespace Tests;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\Vehicle\VehicleAssignmentManager;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Routing\Middleware\ThrottleRequests;

abstract class TestCase extends BaseTestCase
{
    public const BASE_API_URI = '/api';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ThrottleRequests::class);
    }

    public function produceUser(): User
    {
        return User::factory()->create()->first();
    }

    protected function produceVehicleAssignment($count = 10)
    {
        $vehicleAssignmentManager = resolve(VehicleAssignmentManager::class);

        for ($i = 0; $i < $count; $i++) {
            $vehicle = Vehicle::factory()->create();
            $driver = Driver::factory()->create();

            $vehicleAssignmentManager->create($vehicle, $driver);
        }
    }

}
