<?php

namespace App;

enum DbPolyType: string
{
    case USER = 'user';
    case VEHICLE_REQUEST = 'vehicle_request';
    case ACCOUNT_DETAIL = 'account_detail';
    case TRANSACTION = 'transaction';
    case CONFERENCE_REQUEST = 'conference_request';
    case ASSISTANCE_REQUEST = 'assistance_request';
    case AIR_TRAVEL_REQUEST = 'air_travel_request';
}
