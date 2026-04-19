<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppAlertSpecOperator: string
{
    case UnspecifiedOperator = 'UNSPECIFIED_OPERATOR';
    case GreaterThan = 'GREATER_THAN';
    case LessThan = 'LESS_THAN';
}
