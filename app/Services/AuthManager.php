<?php

namespace App\Services;

use App\Models\User;

interface AuthManager
{
    public function authenticate(array $payload): ?User;
    public function generateToken(User $user, string $tokenName = 'auth_token'): string;
    public function invalidateToken(string $token): bool;
    public function getUser(User $user): ?User;
    public function invalidateUserTokens(User $user);
}
