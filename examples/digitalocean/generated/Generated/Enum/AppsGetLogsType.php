<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppsGetLogsType: string
{
    case Unspecified = 'UNSPECIFIED';
    case Build = 'BUILD';
    case Deploy = 'DEPLOY';
    case Run = 'RUN';
    case RunRestarted = 'RUN_RESTARTED';
    case AutoscaleEvent = 'AUTOSCALE_EVENT';
}
