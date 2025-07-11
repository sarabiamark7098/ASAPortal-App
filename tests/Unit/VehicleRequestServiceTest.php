<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\VehicleRequest;
use App\Services\VehicleRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleRequestServiceTest extends TestCase
{
    use RefreshDatabase;
    public VehicleRequestService $vehicleRequestService;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->vehicleRequestService = new VehicleRequestService(new VehicleRequest());

        $this->user = User::first();
    }
    public function test_it_can_create_vehicle_request(): void
    {
        $payload = VehicleRequest::factory()->make()->toArray();
        $this->vehicleRequestService->create([
            ...$payload,
            'user_id' => $this->user->id
        ]);

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertDatabaseCount('transactions', 1);
    }
}
