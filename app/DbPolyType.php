<?php

namespace App;

enum DbPolyType: string
{
    case USER = 'user';
    case VEHICLE_REQUEST = 'vehicle_request';
    case ACCOUNT_DETAIL = 'account_detail';
    case TRANSACTION = 'transaction';
}
