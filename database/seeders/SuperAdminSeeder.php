<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'superadmin@example.com',
            'password' => bcrypt('supersecure'),
        ]);

        $role = Role::where('name', 'super-admin')->first();
        $user->roles()->attach($role); // Assuming User has roles() relation
    }
}
