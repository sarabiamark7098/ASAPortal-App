<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    function authenticate(array $payload) : ?User {
        $loginType = filter_var($payload['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginType, $payload['login'])->first();

        if(!$user){
            throw new AuthenticationException('Invlid Credentials');
        }

        if (!Hash::check($payload['password'], $user->password)) {
            throw new AuthenticationException('Invlid Credentials');
        }

        return $user;
    }

    public function generateToken(User $user, string $tokenName = 'auth_token') : string {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function invalidateToken(string $token): bool {
        $sanctumToken = PersonalAccessToken::findToken($token);

        if (! $sanctumToken) {
            return true;
        }

        return $sanctumToken->delete();
    }

    public function getUser(User $user) : ?User {
        $user->load('roles', 'permissions');
        $user->roles = $user->getRoleNames();
        $user->permissions = $user->getPermissionNames();

        return $user;
    }

    public function invalidateUserTokens(User $user) {
        $user->tokens()->delete();
    }
}
