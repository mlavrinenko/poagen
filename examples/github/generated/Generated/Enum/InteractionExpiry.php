<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum InteractionExpiry: string
{
    case OneDay = 'one_day';
    case ThreeDays = 'three_days';
    case OneWeek = 'one_week';
    case OneMonth = 'one_month';
    case SixMonths = 'six_months';
}
