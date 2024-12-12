<?php

namespace App\Enums;

enum OrderServiceType: string
{
    case EVISA = 'evisa';
    case FAST_TRACK = 'fast_track';
    case EVISA_FAST_TRACK = 'evisa_fast_track';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
