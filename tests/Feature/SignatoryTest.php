<?php

namespace Tests\Feature;

use App\Models\Signatory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignatoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    private string $baseUri = self::BASE_API_URI.'/signatories';

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

    public function test_signatory_creation(): void
    {
        $signatoryData = [
            'full_name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
        ];
        $response = $this->actingAs($this->user)->postJson('/api/signatories', $signatoryData);

        $response->assertCreated();
        $this->assertDatabaseHas('signatories', $signatoryData);

    }

    public function test_signatory_search(): void
    {
        $signatory = Signatory::factory()->create([
            'full_name' => 'John Doe',
            'position' => 'Software Engineer',
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/signatories?query=John');

        $response->assertOk();

        $this->assertEquals('John Doe', $response->json()['data'][0]['full_name']);
        $this->assertEquals('Software Engineer', $response->json()['data'][0]['position']);
    }

    public function test_signatory_update(): void
    {
        $signatory = Signatory::factory()->create();

        $updatedData = [
            'full_name' => 'John Doe',
            'position' => 'Senior Software Engineer',
        ];

        $response = $this->actingAs($this->user)->putJson("/api/signatories/{$signatory->id}", $updatedData);

        $response->assertOk();
        $this->assertDatabaseHas('signatories', $updatedData);
    }
}
