<?php

namespace App\Enums;

enum Status:string
{
    use EnumToArray;
    
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DISAPPROVED = 'disapproved';
}
