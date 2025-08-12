<?php

namespace App\Enums;

enum Status:string
{
    use EnumToArray;
    
    case PENDING = 'pending';
    case PROCESSED = 'processed';
    case NO_AVAILABLE = 'no_available';
    case CANCELLED = 'cancelled';
    case DISAPPROVED = 'disapproved';
    case APPROVED = 'approved';
}
