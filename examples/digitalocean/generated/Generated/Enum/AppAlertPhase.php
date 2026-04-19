<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppAlertPhase: string
{
    case Unknown = 'UNKNOWN';
    case Pending = 'PENDING';
    case Configuring = 'CONFIGURING';
    case Active = 'ACTIVE';
    case Error = 'ERROR';
}
