<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum MonitoringGetDatabaseMysqlOpRatesMetric: string
{
    case Select = 'select';
    case Insert = 'insert';
    case Update = 'update';
    case Delete = 'delete';
}
