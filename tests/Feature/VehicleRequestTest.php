<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\FormFileUpload;
use App\Models\Signatory;
use App\Models\User;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
        $countUploads = 2;
        $payload = VehicleRequest::factory()->make()->toArray();

        $files = [];
        for ($i = 0; $i < $countUploads; $i++) {
            $files[] = [
                'label' => fake()->randomElement(['Document', 'Approval', 'Signature']),
                'file' => UploadedFile::fake()->image('fake_image_'.$i.'.jpg', 500, 500),
            ];
        }
        $payload = [
            ...$payload,
            'files' => $files,
        ];

        $response = $this->actingAs($this->user)->post($this->baseUri, $payload, [
            'Content-Type' => 'multipart/form-data',
        ]);

        $response->assertStatus(201);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertNotEmpty($responseJson);
        $this->assertCount($countUploads, $responseJson['fileable']);
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
        yield ['passengers'];
        yield ['destination'];
        yield ['requester_name'];
    }

    public function test_it_can_process_available_vehicle_request(): void
    {
        $this->produceVehicleAssignment();
        Signatory::factory(20)->create();

        $vehicleRequest = VehicleRequest::factory()->create();
        $vehicleAssignment = VehicleAssignment::first();
        $vehicleRequestId = $vehicleRequest->id;

        $signatories = [
            [
                'label' => 'Requested By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
            [
                'label' => 'Approved By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
        ];

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$vehicleRequestId/process", [
            'vehicle_assignment_id' => $vehicleAssignment->id,
            'signatories' => $signatories,
            'is_vehicle_available' => true
        ]);

        $response->assertStatus(200);
        $vehiceRequestResponse = $response->decodeResponseJson();

        $vehicleRequest = $vehicleRequest->fresh();

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertNotEmpty($vehiceRequestResponse);
        $this->assertEquals($vehicleAssignment->id, $vehiceRequestResponse['vehicle_assignment_id']);
        $this->assertEquals(Status::PROCESSED->value, $vehiceRequestResponse['status']);
        $this->assertTrue($vehiceRequestResponse['is_vehicle_available']);
        $this->assertEquals(count($signatories), $vehicleRequest->signable()->count());
    }

    public function test_it_can_process_unavailable_vehicle_request(): void
    {
        $this->produceVehicleAssignment();
        Signatory::factory(20)->create();
        $signatories = [
            [
                'label' => 'Requested By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
            [
                'label' => 'Approved By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
        ];
        $vehicleRequest = VehicleRequest::factory()->create();
        $vehicleRequestId = $vehicleRequest->id;

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$vehicleRequestId/process", [
            'signatories' => $signatories,
            'is_vehicle_available' => false
        ]);

        $response->assertStatus(200);
        $vehiceRequestResponse = $response->decodeResponseJson();

        $vehicleRequest = $vehicleRequest->fresh();

        $this->assertDatabaseCount('vehicle_requests', 1);
        $this->assertNotEmpty($vehiceRequestResponse);
        $this->assertEquals(Status::NO_AVAILABLE->value, $vehiceRequestResponse['status']);
        $this->assertFalse($vehiceRequestResponse['is_vehicle_available']);
    }

    public function test_it_cannot_process_an_already_processd_vehicle_request(): void
    {
        $this->produceVehicleAssignment();
        Signatory::factory(20)->create();

        $vehicleRequest = VehicleRequest::factory()->create();
        $vehicleRequest->status = Status::PROCESSED;
        $vehicleRequest->save();

        $vehicleAssignment = VehicleAssignment::first();
        $vehicleRequestId = $vehicleRequest->id;

        $signatories = [
            [
                'label' => 'Requested By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
            [
                'label' => 'Approved By',
                'id' => fake()->randomElement(Signatory::pluck('id')),
            ],
        ];

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$vehicleRequestId/process", [
            'vehicle_assignment_id' => $vehicleAssignment->id,
            'signatories' => $signatories,
            'is_vehicle_available' => true
        ]);

        $response->assertStatus(403);
    }

     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
    {

        $vehicleRequest = VehicleRequest::factory()->create();

        $vehicleRequest->status = Status::PROCESSED;
        $vehicleRequest->save();

        $vehicleRequestId = $vehicleRequest->id;


        $response = $this->actingAs($this->user)->putJson("$this->baseUri/$vehicleRequestId", [
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $vehicleRequest = $vehicleRequest->fresh();

        $this->assertEquals($status, $vehicleRequest->status->value);
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
