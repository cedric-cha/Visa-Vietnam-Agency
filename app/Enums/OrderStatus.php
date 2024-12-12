<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'Pending';
    case PROCESSED = 'Processed';
    case TRANSACTION_SUCCESS = 'Transaction successful';
    case TRANSACTION_CANCELED = 'Transaction canceled';
    case TRANSACTION_FAILED = 'Transaction failed';
    case TRANSACTION_IN_PROGRESS = 'Transaction in progress';
    case TRANSACTION_EXPIRED = 'Transaction expired';
    case CANCELLED = 'Cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
