<?php

namespace App\Enums;

enum DatePeriod: string
{
    case TODAY = 'today';
    case YESTERDAY = 'yesterday';
    case THIS_WEEK = 'this_week';
    case THIS_MONTH = 'this_month';
    case LAST_MONTH = 'last_month';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match($this) {
            self::TODAY => __('Today'),
            self::YESTERDAY => __('Yesterday'),
            self::THIS_WEEK => __('This Week'),
            self::THIS_MONTH => __('This Month'),
            self::LAST_MONTH => __('Last Month'),
            self::CUSTOM => __('Custom Period'),
        };
    }
}
