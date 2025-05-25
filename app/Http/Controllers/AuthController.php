<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User registered');

        return response()->json(['message' => 'Registration successful'], 201);
    }

    /**
     * Login user and create token.
     */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Auth::user()->tokens()->delete();

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

    $user = Auth::user();
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged in');

        return response()->json(['message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // public function login(Request $request): JsonResponse
    // {
    //     $credentials = $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required|string',
    //     ]);
    //     $user = User::where('email', $credentials['email'])->first();

    //     // if (! $user || ! Hash::check($credentials['password'], $user->password)) {
    //     //     throw ValidationException::withMessages([
    //     //         'email' => ['Invalid credentials.'],
    //     //     ]);
    //     // }

    //     // Revoke all previous tokens (optional for stricter security)
    //     $user->tokens()->delete();


    //    $token = $user->createToken('auth_token')->plainTextToken;
    //     dd($token);
    //     activity()
    //         ->causedBy($user)
    //         ->withProperties(['ip' => $request->ip()])
    //         ->log('User logged in');

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'user' => $user,
    //     ]);
    // }

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

    /**
     * Get authenticated user's profile.
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('Fetched profile');

        return response()->json($user);
    }
}
