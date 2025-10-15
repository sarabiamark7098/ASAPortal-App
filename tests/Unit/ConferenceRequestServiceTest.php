<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\ConferenceRequest;
use App\Services\Conference\ConferenceRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceRequestServiceTest extends TestCase
{
    use RefreshDatabase;
    public ConferenceRequestService $conferenceRequestService;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->conferenceRequestService = new ConferenceRequestService(new ConferenceRequest());

        $this->user = User::first();
    }

    public function test_it_can_create_conference_request(): void
    {
        $payload = ConferenceRequest::factory()->make()->toArray();
        $this->conferenceRequestService->create([
            ...$payload,
            'user_id' => $this->user->id
        ]);

        $this->assertDatabaseCount('conference_requests', 1);
        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_it_can_search_conference_request(): void
    {
        $count = 10;
        ConferenceRequest::factory()->count($count)->create();
        $result = $this->conferenceRequestService->search();

        $this->assertEquals($count, count($result->items()));
    }

}
