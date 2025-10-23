<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\FormPassenger;
use App\Models\Signatory;
use App\Models\User;
use App\Models\AirTransportRequest;
use App\Models\FormFlight;
use Database\Factories\FlightFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AirTransportOrderRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/air-transport-requests';

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

    public function test_it_can_create_air_transport_request(): void
    {
        Signatory::factory()->count(10)->create();
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

        $countFlights = 4;
        $countPassengers = 5;
        $payload = AirTransportRequest::factory()->make()->toArray();
        $payload = [
            ...$payload,
            'signatories' => $signatories,
            'flights' => FormFlight::factory()->count($countFlights)->make()->toArray(),
            'passengers' => FormPassenger::factory()->count($countPassengers)->make()->toArray(),
        ];
        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertStatus(201);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('air_transport_requests', 1);
        $this->assertNotEmpty($responseJson);
        $this->assertCount($countFlights, $responseJson['flights']);
        $this->assertCount($countPassengers, $responseJson['passengers']);
    }

    public function test_it_can_fetch_air_transport_requests(): void
    {
        $count = 10;
        AirTransportRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_air_transport_requests(): void
    {
        $count = 10;
        AirTransportRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = AirTransportRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_air_transport_requests(string $field): void
    {
        $count = 10;
        AirTransportRequest::factory()->count($count)->create();

        $value = 'The quick brown fox jumps over the lazy dog.';
        $airTransportRequest = AirTransportRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($airTransportRequest->id, $responseJson['data'][0]['id']);

        Schema::disableForeignKeyConstraints();
        AirTransportRequest::query()->truncate();
    }

    public function test_it_can_search_air_transport_requests_using_control_number(): void
    {
        $count = 10;
        AirTransportRequest::factory()->count($count)->create();

        $controlNumber = '2020-01-02-012345';
        $airTransportRequest = AirTransportRequest::factory()->create()->first();

        $airTransportRequest->control_number = $controlNumber;
        $airTransportRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($airTransportRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['requesting_office'];
        yield ['fund_source'];
        yield ['requester_name'];
    }


     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
    {

        $airTransportRequest = AirTransportRequest::factory()->create();

        $airTransportRequest->status = Status::PROCESSED;
        $airTransportRequest->save();

        $airTransportRequestId = $airTransportRequest->id;

        $response = $this->actingAs($this->user)->putJson("$this->baseUri/$airTransportRequestId", [
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $airTransportRequest = $airTransportRequest->fresh();

        $this->assertEquals($status, $airTransportRequest->status->value);
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
