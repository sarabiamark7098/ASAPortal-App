<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\User;
use App\Models\AssistanceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AssistanceRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUri = self::BASE_API_URI.'/assistance-requests';

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

    public function test_it_can_create_assistance_request(): void
    {
        $payload = AssistanceRequest::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->postJson($this->baseUri, $payload);

        $response->assertStatus(201);
        $responseJson = $response->decodeResponseJson();

        $this->assertDatabaseCount('assistance_requests', 1);
        $this->assertNotEmpty($responseJson);
    }

    public function test_it_can_fetch_assistance_requests(): void
    {
        $count = 10;
        AssistanceRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri);
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));
    }

    public function test_it_can_sort_assistance_requests(): void
    {
        $count = 10;
        AssistanceRequest::factory()->count($count)->create();

        $response = $this->actingAs($this->user)->getJson($this->baseUri.'?sort_by=id&sort_order=desc');
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();
        $this->assertEquals($count, count($responseJson['data']));

        $lastRow = AssistanceRequest::orderBy('id', 'desc')->first();
        $this->assertEquals($lastRow->id, $response['data'][0]['id']);
    }

    #[DataProvider('differentTextFields')]
    public function test_it_can_search_text_assistance_requests(string $field): void
    {
        $count = 10;
        AssistanceRequest::factory()->count($count)->create();

        $value = 'The quick brown fox jumps over the lazy dog.';
        $assistanceRequest = AssistanceRequest::factory(1, [
            $field => $value
        ])->create()->first();

        DB::commit();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=brown");
        $response->assertStatus(200);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($assistanceRequest->id, $responseJson['data'][0]['id']);

        AssistanceRequest::query()->truncate();
    }

    public function test_it_can_search_assistance_requests_using_control_number(): void
    {
        $count = 10;
        AssistanceRequest::factory()->count($count)->create();

        $controlNumber = '2020-01-02-012345';
        $assistanceRequest = AssistanceRequest::factory()->create()->first();

        $assistanceRequest->control_number = $controlNumber;
        $assistanceRequest->save();

        $response = $this->actingAs($this->user)->getJson("$this->baseUri?query=12345");
        $response->assertStatus(200);
        $response = $response->decodeResponseJson();

        $this->assertEquals($assistanceRequest->id, $response['data'][0]['id']);
    }

    public static function differentTextFields()
    {
        yield ['requesting_office'];
        yield ['details'];
        yield ['requester_name'];
    }

     #[DataProvider('approveDisapproveDataProvider')]
    public function test_it_approve_or_disapproved_form_request(string $status): void
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
        $assistanceRequest = AssistanceRequest::factory()->create([
            'status' => Status::PENDING,
        ]);

        $assistanceRequestId = $assistanceRequest->id;
        $response = $this->actingAs($this->user)->postJson("$this->baseUri/$assistanceRequestId", [
            'signatories' => $signatories,
            'status' => $status,
        ]);

        $response->assertStatus(200);
        $assistanceRequestResponse = $response->decodeResponseJson();

        $assistanceRequest = $assistanceRequest->fresh();

        $this->assertDatabaseCount('assistance_requests', 1);
        $this->assertNotEmpty($assistanceRequestResponse);
        $this->assertEquals($status, $assistanceRequest->status->value);
        $this->assertEquals(count($signatories), $assistanceRequest->signable()->count());
    }

    public static function approveDisapproveDataProvider(): \Generator
    {
        yield [Status::APPROVED->value];
        yield [Status::DISAPPROVED->value];
    }

}
