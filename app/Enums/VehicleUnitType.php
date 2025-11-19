<?php

namespace App\Enums;

enum VehicleUnitType: string
{
    use EnumToArray;

    case pickup = 'pickup';
    case van = 'van';
    case mpv = 'mpv';
    case suv = 'suv';
    case auv = 'auv';
    case hatchback = 'hatchback';
    case sedan = 'sedan';
    case truck = 'truck';
    case bus = 'bus';
}
