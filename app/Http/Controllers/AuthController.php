<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\AccountDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\AuthManager;

class AuthController extends Controller
{
    private AuthManager $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }
    /**
     * Register a new user.
     */
    public function register(AuthRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $user = User::create([
                'email'    => $validated['email'],
                'username' => $validated['username'] ?? null,
                'password' => Hash::make($validated['password']),
            ]);

            // Assign default role to the user
            $user->assignRole('client'); // Assuming 'user' is a default role
            if (!$user->hasRole('client')) {
                return response()->json(['message' => 'Failed to assign default role'], 500);
            }
            $account = AccountDetail::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'] ?? null,
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'] ?? null,
                'extension_name' => $validated['extension_name'] ?? null,
                'position' => $validated['position'] ?? null,
                'birth_date' => !empty($validated['birth_date']) ? Carbon::parse($validated['birth_date'])->format('Y-m-d') : null,
                'office_id' => !empty($validated['office']) ? $validated['office'] : $validated['division'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
            ]);

            activity()
                ->causedBy($user)
                ->withProperties(['ip' => $request->ip()])
                ->log('User registered');

            return response()->json(['message' => 'Registration successful', 'login' => $validated['email'], 'password' => $validated['password']], 201);
        });
    }

    /**
     * Login user and create token.
     */

    public function login(AuthRequest $request): JsonResponse
    {
        $user = $this->authManager->authenticate($request->validated());

        $this->authManager->invalidateUserTokens($user);

        $token = $this->authManager->generateToken($user);

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged in');

        return response()->json(['message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->authManager->getUser($user),
        ]);
    }

    /**
     * Logout user (revoke current token).
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        // Delete the token used in current request
        $user->currentAccessToken()->delete();

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged out');

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('roles', 'permissions');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getPermissionNames()
        ]);
    }

}
