<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum MonitoringGetDropletBandwidthMetricsDirection: string
{
    case Inbound = 'inbound';
    case Outbound = 'outbound';
}
