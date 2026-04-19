<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum SecurityGetScanSeverity: string
{
    case Low = 'LOW';
    case Medium = 'MEDIUM';
    case High = 'HIGH';
    case Critical = 'CRITICAL';
}
