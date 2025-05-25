<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
         $permissions = [
            'view users',
            'edit users',
            'delete users',
            'create users',
            'assign roles',
            'view dashboard',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }


         $rolesWithPermissions = [
            'superadmin' => Permission::all()->pluck('name')->toArray(), // all permissions
            'supervisor' => ['view users', 'view dashboard'],
            'manager' => ['view users', 'edit users', 'view dashboard'],
            'driver' => ['view dashboard'],
            'client' => [],
        ];

        // Create roles and assign permissions
        foreach ($rolesWithPermissions as $role => $perms) {
            $roleModel = Role::firstOrCreate(['name' => $role]);
            $roleModel->syncPermissions($perms);
        }
    }
}
