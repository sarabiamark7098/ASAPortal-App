<?php

namespace Tests\Unit;

use App\Enums\Status;
use App\Models\User;
use App\Models\VehicleAssignment;
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

    public function test_it_can_search_vehicle_request(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();
        $result = $this->vehicleRequestService->search();

        $this->assertEquals($count, count($result->items()));
    }

    public function test_it_can_approve_vehicle_request(): void
    {
        $payload = VehicleRequest::factory()->make()->toArray();
        $vehicleRequest = $this->vehicleRequestService->create([
            ...$payload,
            'user_id' => $this->user->id
        ]);

        $this->produceVehiceAssignment();

        $vehicleAssignment = VehicleAssignment::first();

        $this->vehicleRequestService->approve($vehicleRequest, $vehicleAssignment);

        $vehicleRequest = $vehicleRequest->fresh();

        $this->assertEquals($vehicleAssignment->id, $vehicleRequest->vehicle_assignment_id);
        $this->assertEquals(Status::APPROVED, $vehicleRequest->status);
    }
}
