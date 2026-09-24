<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case TRANSFER = 'transfer';

    public function label(): string
    {
        return match ($this) {
            self::CASH => __('Cash'),
            self::TRANSFER => __('Bank Transfer'),
        };
    }
}
