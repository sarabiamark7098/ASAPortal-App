<?php

namespace App\Providers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use App\Services\Driver\DriverService;
use App\Services\Vehicle\VehicleAssignmentManager;
use App\Services\Vehicle\VehicleAssignmentService;
use App\Services\Vehicle\VehicleRequestManager;
use App\Services\Vehicle\VehicleRequestService;
use App\Services\Vehicle\VehicleManager;
use App\Services\Vehicle\VehicleService;
use Illuminate\Support\ServiceProvider;
use App\Policies\VehicleRequestPolicy;
use App\Services\Driver\DriverManager;
use App\Services\Pdf\PdfManager;
use App\Services\Pdf\PdfService;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VehicleRequestManager::class, function () {
            return new VehicleRequestService(new VehicleRequest());
        });
        $this->app->bind(VehicleAssignmentManager::class, function () {
            return new VehicleAssignmentService(new VehicleAssignment());
        });
        $this->app->bind(PdfManager::class, function () {
            return new PdfService([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
            ]);
        });
        $this->app->bind(DriverManager::class, function () {
            return new DriverService(new Driver());
        });
        $this->app->bind(VehicleManager::class, function () {
            return new VehicleService(new Vehicle());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(VehicleRequest::class, VehicleRequestPolicy::class);
    }
}
