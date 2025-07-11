<?php

namespace App\Providers;

use App\DbPolyType;
use App\Models\AccountDetail;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VehicleRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PolyMorphMapProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            DbPolyType::USER->value => User::class,
            DbPolyType::ACCOUNT_DETAIL->value => AccountDetail::class,
            DbPolyType::VEHICLE_REQUEST->value => VehicleRequest::class,
            DbPolyType::TRANSACTION->value => Transaction::class,
        ]);
    }
}
