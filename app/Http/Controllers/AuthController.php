<?php

namespace App\Http\Controllers;

use App\Models\AccountDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required_without:email|nullable|string|unique:users,username',
            'email' => 'required_without:username|nullable|email|unique:users,email',
            'password' => 'required|string|min:8',
            'firstName' => 'required|string|max:255',
            'middleName' => 'string|max:255|nullable',
            'lastName' => 'required|string|max:255',
            'extensionName' => 'string|max:255|nullable',
            'position' => 'required|string|max:255|nullable',
            'birthDate' => 'required|date|nullable',
            'office' => 'exists:offices,id|nullable',
            'division' => 'exists:offices,id|nullable',
            'contactNumber' => 'required|string|max:15|nullable',
        ]);

        $user = User::create([
            'email'    => $validated['email'],
            'username' => $validated['username'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);


        // Check if user was created successfully
        if (!$user || !$user->id) {
            return response()->json(['message' => 'User creation failed'], 500);
        }

        // Assign default role to the user
        $user->assignRole('client'); // Assuming 'user' is a default role
        if (!$user->hasRole('client')) {
            return response()->json(['message' => 'Failed to assign default role'], 500);
        }
        $account = AccountDetails::create([
            'user_id' => $user->id,
            'firstName' => $validated['firstName'] ?? null,
            'middleName' => $validated['middleName'] ?? null,
            'lastName' => $validated['lastName'] ?? null,
            'extensionName' => $validated['extensionName'] ?? null,
            'position' => $validated['position'] ?? null,
            'birthDate' => !empty($validated['birthDate']) ? Carbon::parse($validated['birthDate'])->format('Y-m-d') : null,
            'office_id' => !empty($validated['office']) ? $validated['office'] : $validated['division'] ?? null,
            'contactNumber' => $validated['contactNumber'] ?? null,
        ]);

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User registered');

        return response()->json(['message' => 'Registration successful', 'login' => $validated['email'], 'password' => $validated['password']], 201);
    }

    /**
     * Login user and create token.
     */

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Auth::user()->tokens()->delete();

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        $user = Auth::user();
        $user->load('roles', 'permissions');
        $user->roles = $user->getRoleNames();
        $user->permissions = $user->getPermissionNames();
        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged in');

        return response()->json(['message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
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

}
