<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DriverTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    private string $baseUri = self::BASE_API_URI.'/vehicle-assignments';

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

    public function test_driver_creation(): void
    {
        $driverData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => $this->faker->phoneNumber,
            'position' => $this->faker->jobTitle,
            'designation' => $this->faker->word,
            'official_station' => $this->faker->word,
        ];

        $response = $this->actingAs($this->user)->postJson('/api/drivers', $driverData);

        $response->assertCreated();
        $this->assertDatabaseHas('drivers', $driverData);
    }

    public function test_driver_search(): void
    {
        $driver = Driver::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'contact_number' => '1234567890',
            'position' => 'Software Engineer',
            'designation' => 'Junior Developer',
            'official_station' => 'Remote',
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/drivers?query=John');

        $response->assertOk();
        $this->assertEquals('John', $response->json()['data'][0]['first_name']);
    }

    public function test_driver_update(): void
    {
        $driver = Driver::factory()->create();

        $updatedData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'contact_number' => '0987654321',
            'position' => 'Senior Developer',
            'designation' => 'Team Lead',
            'official_station' => 'Headquarters',
        ];

        $response = $this->actingAs($this->user)->putJson("/api/drivers/{$driver->id}", $updatedData);

        $response->assertOk();
        $this->assertDatabaseHas('drivers', $updatedData);
    }
}
