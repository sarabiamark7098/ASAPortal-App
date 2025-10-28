<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\FormGuest;
use App\Models\Signatory;
use App\Models\User;
use App\Models\EntryRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class EntryRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/entry-requests';

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

    public function test_it_can_create_entry_request(): void
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

        $countGuests = 5;
        $payload = EntryRequest::factory()->make()->toArray();
        $payload = [
            ...$payload,
            'signatories' => $signatories,
            'guests' => FormGuest::factory()->count($countGuests)->make()->toArray(),
        ];

        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertStatus(201);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('entry_requests', 1);
        $this->assertNotEmpty($responseJson);
        $this->assertCount($countGuests, $responseJson['guests']);
    }

    public function test_it_can_fetch_entry_requests(): void
    {
        $count = 10;
        EntryRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_entry_requests(): void
    {
        $count = 10;
        EntryRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = EntryRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_entry_requests(string $field): void
    {
        $count = 10;
        EntryRequest::factory()->count($count)->create();

        $value = 'The quick brown fox jumps over the lazy dog.';
        $entryRequest = EntryRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($entryRequest->id, $responseJson['data'][0]['id']);

        Schema::disableForeignKeyConstraints();
        EntryRequest::query()->truncate();
    }

    public function test_it_can_search_entry_requests_using_control_number(): void
    {
        $count = 10;
        EntryRequest::factory()->count($count)->create();

        $controlNumber = '2020-01-02-012345';
        $entryRequest = EntryRequest::factory()->create()->first();

        $entryRequest->control_number = $controlNumber;
        $entryRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($entryRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['requesting_office'];
        yield ['requester_name'];
    }


     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
    {

        $entryRequest = EntryRequest::factory()->create();

        $entryRequest->status = Status::PROCESSED;
        $entryRequest->save();

        $entryRequestId = $entryRequest->id;

        $response = $this->actingAs($this->user)->putJson("$this->baseUri/$entryRequestId", [
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $entryRequest = $entryRequest->fresh();

        $this->assertEquals($status, $entryRequest->status->value);
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
