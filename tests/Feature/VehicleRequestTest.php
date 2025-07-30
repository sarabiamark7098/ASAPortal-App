<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VehicleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/vehicle-requests';

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

    public function test_it_can_create_vehicle_request(): void
    {
        $payload = VehicleRequest::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertStatus(201);
        $this->assertDatabaseCount('vehicle_requests', 1);
    }

    public function test_it_can_fetch_vehicle_requests(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);

        $response->assertStatus(200);

        $response = $response->decodeResponseJson();
        $this->assertEquals($count, count($response['data']));
    }

    public function test_it_can_sort_vehicle_requests(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');

        $response->assertStatus(200);

        $response = $response->decodeResponseJson();
        $this->assertEquals($count, count($response['data']));

        $lastRow = VehicleRequest::orderBy('id', 'desc')->first();

        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }
}
