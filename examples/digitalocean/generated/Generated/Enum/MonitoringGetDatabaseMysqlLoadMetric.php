<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum MonitoringGetDatabaseMysqlLoadMetric: string
{
    case Load1 = 'load1';
    case Load5 = 'load5';
    case Load15 = 'load15';
}
