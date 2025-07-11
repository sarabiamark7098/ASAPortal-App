<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\AuthManager;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;
    public AuthService $authManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->authManager = resolve(AuthManager::class);
    }

    public function test_it_can_authenticate_user(): void
    {
        $user = User::where('email', 'superadmin@example.com')->first();
        $authUser = $this->authManager->authenticate([
            'login' => $user->email,
            'password' => 'supersecure'
        ]);
        $this->assertEquals($user->id, $authUser->id);
    }

    public function test_it_errors_on_invalid_password(): void
    {
        $this->expectException(AuthenticationException::class);
        $user = User::where('email', 'superadmin@example.com')->first();
        $this->authManager->authenticate([
            'login' => $user->email,
            'password' => fake()->password()
        ]);
    }

    public function test_it_errors_on_invalid_username(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->authManager->authenticate([
            'login' => fake()->userName(),
            'password' => 'supersecure'
        ]);
    }

    public function test_it_can_generate_token(): void
    {
        $user = User::where('email', 'superadmin@example.com')->first();
        $token = $this->authManager->generateToken($user);
        $this->assertNotNull($token);
    }

    public function test_it_can_invalidate_token(): void
    {
        $user = User::where('email', 'superadmin@example.com')->first();
        $token = $this->authManager->generateToken($user);
        $this->authManager->invalidateToken($token);

        $this->assertEmpty($user->tokens);
    }

    public function test_it_can_attach_user_roles(): void
    {
        $user = User::where('email', 'superadmin@example.com')->first();
        $user = $this->authManager->getUser($user)->toArray();

        $this->assertArrayHasKey('roles', $user);
        $this->assertArrayHasKey('permissions', $user);
    }

    public function test_it_can_invalidate_tokens(): void
    {
        $user = User::where('email', 'superadmin@example.com')->first();
        $this->authManager->invalidateUserTokens($user);

        $this->assertEmpty($user->tokens);
    }
    
}
