<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\User;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
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
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertNotEmpty($responseJson);
    }

    public function test_it_can_fetch_vehicle_requests(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_vehicle_requests(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = VehicleRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_vehicle_requests(string $field): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();
        
        $value = 'The quick brown fox jumps over the lazy dog.';
        $vehicleRequest = VehicleRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($vehicleRequest->id, $responseJson['data'][0]['id']);

        VehicleRequest::query()->truncate();
    }

    public function test_it_can_search_vehicle_requests_using_control_number(): void
    {
        $count = 10;
        VehicleRequest::factory()->count($count)->create();
        
        $controlNumber = '2020-01-02-012345';
        $vehicleRequest = VehicleRequest::factory()->create()->first();

        $vehicleRequest->control_number = $controlNumber;
        $vehicleRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($vehicleRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['requesting_office'];
        yield ['purpose'];
        yield ['passengers'];
        yield ['destination'];
        yield ['requester_name'];
    }

    public function test_it_can_approve_vehicle_request(): void
    {
        $this->produceVehiceAssignment();

        $vehicleRequest = VehicleRequest::factory()->create();
        $vehicleAssignment = VehicleAssignment::first();
        $vehicleRequestId = $vehicleRequest->id;


        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$vehicleRequestId/approve", [
            'vehicle_assignment_id' => $vehicleAssignment->id
        ]);

        $response->assertStatus(200);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertNotEmpty($responseJson);
        $this->assertEquals($vehicleAssignment->id, $responseJson['vehicle_assignment_id']);
        $this->assertEquals(Status::APPROVED->value, $responseJson['status']);
    }

}
