<?php

namespace App\Enums;

trait EnumToArray
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function asArray(): array
    {
        return array_combine(self::names(), self::values());
    }
}