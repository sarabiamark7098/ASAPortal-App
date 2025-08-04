<?php

namespace App\Enums;

use EnumToArray;

enum Status:string
{
    use EnumToArray;
    
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DISAPPROVED = 'disapproved';
}
