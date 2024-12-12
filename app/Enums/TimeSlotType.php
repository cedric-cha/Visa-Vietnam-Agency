<?php

namespace App\Enums;

enum TimeSlotType: string
{
    case ARRIVAL = 'Arrival';
    case DEPARTURE = 'Departure';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
