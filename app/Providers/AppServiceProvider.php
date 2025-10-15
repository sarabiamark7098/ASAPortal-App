<?php

namespace App\Providers;

// Models

use App\Models\AssistanceRequest;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use App\Models\ConferenceRequest;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Signatory;

// Managers
use App\Services\Assistance\AssistanceRequestManager;
use App\Services\Assistance\AssistanceRequestService;
use App\Services\Vehicle\VehicleRequestManager;
use App\Services\Vehicle\VehicleAssignmentManager;
use App\Services\Conference\ConferenceRequestManager;
use App\Services\Vehicle\VehicleManager;
use App\Services\Driver\DriverManager;
use App\Services\Signatory\SignatoryManager;
use App\Services\Pdf\PdfManager;

// Services
use App\Services\Vehicle\VehicleRequestService;
use App\Services\Vehicle\VehicleAssignmentService;
use App\Services\Conference\ConferenceRequestService;
use App\Services\Vehicle\VehicleService;
use App\Services\Driver\DriverService;
use App\Services\Signatory\SignatoryService;
use App\Services\Pdf\PdfService;

// Providers
use Illuminate\Support\ServiceProvider;

// Policies
use App\Policies\ConferenceRequestPolicy;
use App\Policies\VehicleRequestPolicy;

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
        $this->app->bind(SignatoryManager::class, function () {
            return new SignatoryService(new Signatory());
        });
        $this->app->bind(ConferenceRequestManager::class, function () {
            return new ConferenceRequestService(new ConferenceRequest());
        });
        $this->app->bind(AssistanceRequestManager::class, function () {
            return new AssistanceRequestService(new AssistanceRequest());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(VehicleRequest::class, VehicleRequestPolicy::class);
        Gate::policy(ConferenceRequest::class, ConferenceRequestPolicy::class);
    }
}
