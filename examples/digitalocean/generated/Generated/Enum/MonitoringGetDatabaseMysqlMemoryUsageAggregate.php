<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum MonitoringGetDatabaseMysqlMemoryUsageAggregate: string
{
    case Avg = 'avg';
    case Max = 'max';
    case Min = 'min';
}
