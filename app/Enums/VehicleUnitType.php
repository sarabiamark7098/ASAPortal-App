<?php

namespace App\Enums;

use EnumToArray;

enum VehicleUnitType:string
{
    use EnumToArray;
    
    case PICKUP = 'pickup';
    case VAN = 'van';
    case MPV = 'mpv';
    case SUV = 'suv';
}
