<?php

namespace App\Enums;

enum ConferenceRoom: string
{
    use EnumToArray;

    case maagap = 'maagap';
    case magiting = 'magiting';
    case seminar = 'seminar';
}
