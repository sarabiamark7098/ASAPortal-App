<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function getAllUsers() {
        return User::with('accountDetails.section')->get();
    }

    public function updateUser(Request $request) {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'extension_name' => 'nullable|string',
            'position' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'contact_number' => 'nullable|string|max:15',
            'office' => 'exists:offices,id|nullable',
        ]);
    }
}

