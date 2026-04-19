<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum AppEgressTypeSpec: string
{
    case Autoassign = 'AUTOASSIGN';
    case DedicatedIp = 'DEDICATED_IP';
}
