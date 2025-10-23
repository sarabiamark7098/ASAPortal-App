<?php

namespace App\Providers;

use App\DbPolyType;
use App\Models\AccountDetail;
use App\Models\AirTransportRequest;
use App\Models\AssistanceRequest;
use App\Models\ConferenceRequest;
use App\Models\JanitorialRequest;
use App\Models\OvernightParkingRequest;
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
            DbPolyType::ASSISTANCE_REQUEST->value => AssistanceRequest::class,
            DbPolyType::CONFERENCE_REQUEST->value => ConferenceRequest::class,
            DbPolyType::AIR_TRANSPORT_REQUEST->value => AirTransportRequest::class,
            DbPolyType::OVERNIGHT_PARKING_REQUEST->value => OvernightParkingRequest::class,
            DbPolyType::JANITORIAL_REQUEST->value => JanitorialRequest::class,
            DbPolyType::TRANSACTION->value => Transaction::class,
        ]);

    }
}
