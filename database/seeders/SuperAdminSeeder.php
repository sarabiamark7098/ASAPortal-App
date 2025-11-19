<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'superadmin@example.com',
            'password' => 'supersecure',
            'email_verified_at' => now(),
        ]);
        $user->assignRole('superadmin');

        $user->accountDetail()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'middle_name' => '',
            'extension_name' => '',
            'position' => 'Super Administrator',
            'birth_date' => null,
            'contact_number' => null,
            'office_id' => 1, // Assuming office_id 1 exists
        ]);
    }
}
