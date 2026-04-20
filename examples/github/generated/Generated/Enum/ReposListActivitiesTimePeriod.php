<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListActivitiesTimePeriod: string
{
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Quarter = 'quarter';
    case Year = 'year';
}
