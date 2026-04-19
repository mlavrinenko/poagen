<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppAlertSpecWindow: string
{
    case UnspecifiedWindow = 'UNSPECIFIED_WINDOW';
    case FiveMinutes = 'FIVE_MINUTES';
    case TenMinutes = 'TEN_MINUTES';
    case ThirtyMinutes = 'THIRTY_MINUTES';
    case OneHour = 'ONE_HOUR';
}
