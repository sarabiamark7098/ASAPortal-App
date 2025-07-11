<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap route bindings and pattern filters.
     */
    public function boot(): void
    {
        // Load API routes with 'api' middleware and 'api' prefix
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Load Web routes with 'web' middleware
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
