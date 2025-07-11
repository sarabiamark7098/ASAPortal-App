<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'superadmin@example.com',
            'password' => bcrypt('supersecure'),
        ]);
        $user->assignRole('superadmin');
        DB::table('account_details')->insert([
            'firstName' => 'Super',
            'lastName' => 'Admin',
            'middleName' => '',
            'extensionName' => '',
            'position' => 'Super Administrator',
            'birthDate' => null,
            'contactNumber' => null,
            'user_id' => $user->id,
            'office_id' => 1, // Assuming office_id 1 exists
        ]);
        DB::table('users')->where('id', $user->id)->update([
            'email_verified_at' => now(),
        ]);
    }
}
