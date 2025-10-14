<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\User;
use App\Models\OvernightParkingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OvernightParkingRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/overnight-parking-requests';

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

    public function test_it_can_create_overnight_parking_request(): void
    {
        $payload = OvernightParkingRequest::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertStatus(201);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('overnight_parking_requests', 1);
        $this->assertNotEmpty($responseJson);
    }

    public function test_it_can_fetch_overnight_parking_requests(): void
    {
        $count = 10;
        OvernightParkingRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_overnight_parking_requests(): void
    {
        $count = 10;
        OvernightParkingRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = OvernightParkingRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_overnight_parking_requests(string $field): void
    {
        $count = 10;
        OvernightParkingRequest::factory()->count($count)->create();

        $value = 'The quick brown fox jumps over the lazy dog.';
        $overnightParkingRequest = OvernightParkingRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($overnightParkingRequest->id, $responseJson['data'][0]['id']);

        OvernightParkingRequest::query()->truncate();
    }

    public function test_it_can_search_overnight_parking_requests_using_control_number(): void
    {
        $count = 10;
        OvernightParkingRequest::factory()->count($count)->create();

        $controlNumber = '2020-01-02-012345';
        $overnightParkingRequest = OvernightParkingRequest::factory()->create()->first();

        $overnightParkingRequest->control_number = $controlNumber;
        $overnightParkingRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($overnightParkingRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['justification'];
        yield ['requester_name'];
    }

    public function test_it_can_process_overnight_parking_request(): void
    {
        Signatory::factory(20)->create();

        $overnightParkingRequest = OvernightParkingRequest::factory()->create();
        $overnightParkingRequestId = $overnightParkingRequest->id;

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

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$overnightParkingRequestId/process", [
            'signatories' => $signatories,
        ]);

        $response->assertStatus(200);
        $overnightParkingRequestResponse = $response->decodeResponseJson();

        $overnightParkingRequest = $overnightParkingRequest->fresh();

        $this->assertDatabaseCount('overnight_parking_requests', 1);
        $this->assertNotEmpty($overnightParkingRequestResponse);
        $this->assertEquals(Status::PROCESSED->value, $overnightParkingRequestResponse['status']);
        $this->assertEquals(count($signatories), $overnightParkingRequest->signable()->count());
    }

    public function test_it_cannot_process_an_already_processed_overnight_parking_request(): void
    {
        Signatory::factory(20)->create();

        $overnightParkingRequest = OvernightParkingRequest::factory()->create();
        $overnightParkingRequest->status = Status::PROCESSED;
        $overnightParkingRequest->save();

        $overnightParkingRequest = OvernightParkingRequest::first();
        $overnightParkingRequestId = $overnightParkingRequest->id;

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

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$overnightParkingRequestId/process", [
            'signatories' => $signatories,
        ]);

        $response->assertStatus(403);
    }

     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
    {

        $overnightParkingRequest = OvernightParkingRequest::factory()->create();

        $overnightParkingRequest->status = Status::PROCESSED;
        $overnightParkingRequest->save();

        $overnightParkingRequestId = $overnightParkingRequest->id;

        $response = $this->actingAs($this->user)->putJson("$this->baseUri/$overnightParkingRequestId", [
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $overnightParkingRequest = $overnightParkingRequest->fresh();

        $this->assertEquals($status, $overnightParkingRequest->status->value);
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
