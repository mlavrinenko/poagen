<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum InstanceSizeCpuType: string
{
    case Unspecified = 'UNSPECIFIED';
    case Shared = 'SHARED';
    case Dedicated = 'DEDICATED';
}
