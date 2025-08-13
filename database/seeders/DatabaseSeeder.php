<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Signatory;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\Vehicle\VehicleAssignmentManager;
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
            $this->makeSignatories();
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

    protected function makeSignatories($count = 10) {
        Signatory::factory($count)->create();
    }
}
