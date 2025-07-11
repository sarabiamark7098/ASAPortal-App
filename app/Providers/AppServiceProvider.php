<?php

namespace App\Providers;

use App\Models\VehicleRequest;
use App\Services\VehicleRequestManager;
use App\Services\VehicleRequestService;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
