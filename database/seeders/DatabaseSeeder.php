<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\VehicleAssignmentManager;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            OfficeSeeder::class,
            SuperAdminSeeder::class,
            TypeOfRequestSeeder::class,
        ]);

        if (! app()->runningUnitTests()) {
            $this->makeVehicleAssignments();
        }

    }

    protected function makeVehicleAssignments($count = 10) {
        $vehicleAssignmentManager = resolve(VehicleAssignmentManager::class);
        
        for ($i=0; $i < $count; $i++) { 
            $vehicle = Vehicle::factory()->create();
            $driver = Driver::factory()->create();

            $vehicleAssignmentManager->create($vehicle, $driver);
        }
    }
}
