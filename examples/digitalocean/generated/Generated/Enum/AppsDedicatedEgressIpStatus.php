<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppsDedicatedEgressIpStatus: string
{
    case Unknown = 'UNKNOWN';
    case Assigning = 'ASSIGNING';
    case Assigned = 'ASSIGNED';
    case Removed = 'REMOVED';
}
