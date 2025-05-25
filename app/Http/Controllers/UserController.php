<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    // Require authentication
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Get authenticated user's profile
    public function profile(Request $request)
    {
        $user = $request->user();

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('Viewed profile');

        return response()->json($user);
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('Updated profile');

        return response()->json(['message' => 'Profile updated successfully.']);
    }

    // List all users (admin only)
    public function index()
    {
        $this->authorize('viewAny', User::class); // optional: use Laravel policies

        $users = User::latest()->paginate(10);

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed user list');

        return response()->json($users);
    }

    // Show single user (admin)
    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('view', $user); // optional

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['viewed_user_id' => $id])
            ->log('Viewed user details');

        return response()->json($user);
    }
}

