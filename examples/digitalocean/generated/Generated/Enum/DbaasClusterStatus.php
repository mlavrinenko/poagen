<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum DbaasClusterStatus: string
{
    case Creating = 'CREATING';
    case Online = 'ONLINE';
    case Poweroff = 'POWEROFF';
    case Rebuilding = 'REBUILDING';
    case Rebalancing = 'REBALANCING';
    case Decommissioned = 'DECOMMISSIONED';
    case Forking = 'FORKING';
    case Migrating = 'MIGRATING';
    case Resizing = 'RESIZING';
    case Restoring = 'RESTORING';
    case PoweringOn = 'POWERING_ON';
    case Unhealthy = 'UNHEALTHY';
}
