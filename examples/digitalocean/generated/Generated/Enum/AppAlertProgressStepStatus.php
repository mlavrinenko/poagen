<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppAlertProgressStepStatus: string
{
    case Unknown = 'UNKNOWN';
    case Pending = 'PENDING';
    case Running = 'RUNNING';
    case Error = 'ERROR';
    case Success = 'SUCCESS';
}
