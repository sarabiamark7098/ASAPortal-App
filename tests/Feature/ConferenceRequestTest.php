<?php

namespace Tests\Feature;

use App\Enums\ConferenceRoom;
use App\Enums\Status;
use App\Models\Signatory;
use App\Models\User;
use App\Models\ConferenceRequest;
use App\Models\FormFileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ConferenceRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/conference-requests';

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

    public function test_it_can_create_conference_request(): void
    {
        $countUploads = 2;
        $payload = ConferenceRequest::factory()->make()->toArray();

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

        $this->assertDatabaseCount('conference_requests', 1);
        $this->assertNotEmpty($responseJson);
        $this->assertCount($countUploads, $responseJson['fileable']);
    }

    public function test_it_can_fetch_conference_requests(): void
    {
        $count = 10;
        ConferenceRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_conference_requests(): void
    {
        $count = 10;
        ConferenceRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = ConferenceRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_conference_requests(string $field): void
    {
        $count = 10;
        ConferenceRequest::factory()->count($count)->create();

        $value = 'The quick brown fox jumps over the lazy dog.';
        $conferenceRequest = ConferenceRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($conferenceRequest->id, $responseJson['data'][0]['id']);

        ConferenceRequest::query()->truncate();
    }

    public function test_it_can_search_conference_requests_using_control_number(): void
    {
        $count = 10;
        ConferenceRequest::factory()->count($count)->create();

        $controlNumber = '2020-01-02-012345';
        $conferenceRequest = ConferenceRequest::factory()->create()->first();

        $conferenceRequest->control_number = $controlNumber;
        $conferenceRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($conferenceRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['requesting_office'];
        yield ['purpose'];
        yield ['requester_name'];
    }

    public function test_it_can_process_available_conference_request(): void
    {
        Signatory::factory(20)->create();

        $conferenceRequest = ConferenceRequest::factory()->create();
        $conferenceRequestId = $conferenceRequest->id;

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

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$conferenceRequestId/process", [
            'signatories' => $signatories,
            'is_conference_available' => true
        ]);

        $response->assertStatus(200);
        $conferenceRequestResponse = $response->decodeResponseJson();

        $conferenceRequest = $conferenceRequest->fresh();

        $this->assertDatabaseCount('conference_requests', 1);
        $this->assertNotEmpty($conferenceRequestResponse);
        $this->assertEquals(Status::PROCESSED->value, $conferenceRequestResponse['status']);
        $this->assertEquals(count($signatories), $conferenceRequest->signable()->count());
    }

    public function test_it_can_process_unavailable_conference_request(): void
    {
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
        $conferenceRequest = ConferenceRequest::factory()->create();
        $conferenceRequestId = $conferenceRequest->id;

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$conferenceRequestId/process", [
            'signatories' => $signatories,
            'is_conference_available' => false
        ]);

        $response->assertStatus(200);
        $conferenceRequestResponse = $response->decodeResponseJson();

        $conferenceRequest = $conferenceRequest->fresh();

        $this->assertDatabaseCount('conference_requests', 1);
        $this->assertNotEmpty($conferenceRequestResponse);
        $this->assertEquals(Status::NO_AVAILABLE->value, $conferenceRequestResponse['status']);
    }

    public function test_it_cannot_process_an_already_processd_conference_request(): void
    {
        Signatory::factory(20)->create();

        $conferenceRequest = ConferenceRequest::factory()->create();
        $conferenceRequest->status = Status::PROCESSED;
        $conferenceRequest->save();

        $conferenceRequest = ConferenceRequest::first();
        $conferenceRequestId = $conferenceRequest->id;

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

        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$conferenceRequestId/process", [
            'signatories' => $signatories,
            'is_conference_available' => true
        ]);

        $response->assertStatus(403);
    }

     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
    {

        $conferenceRequest = ConferenceRequest::factory()->create();

        $conferenceRequest->status = Status::PROCESSED;
        $conferenceRequest->save();

        $conferenceRequestId = $conferenceRequest->id;

        $response = $this->actingAs($this->user)->putJson("$this->baseUri/$conferenceRequestId", [
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $conferenceRequest = $conferenceRequest->fresh();

        $this->assertEquals($status, $conferenceRequest->status->value);
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
