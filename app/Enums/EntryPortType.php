<?php

namespace App\Enums;

enum EntryPortType: string
{
    case SEA_PORT = 'Seaport';
    case AIR_PORT = 'Airport';
    case LAND_PORT = 'Land port';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
