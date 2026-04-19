<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum MonitoringGetDatabaseMysqlSchemaLatencyMetric: string
{
    case Insert = 'insert';
    case Fetch = 'fetch';
    case Update = 'update';
    case Delete = 'delete';
}
