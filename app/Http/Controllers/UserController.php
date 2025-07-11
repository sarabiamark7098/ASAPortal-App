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
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'lastName' => 'required|string',
            'extensionName' => 'nullable|string',
            'position' => 'nullable|string',
            'birthDate' => 'nullable|date',
            'contactNumber' => 'nullable|string|max:15',
            'office' => 'exists:offices,id|nullable',
        ]);
    }
}

