<?php

namespace App;

enum Status:string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DISAPPROVED = 'disapproved';
}
