<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiIndexedDataSourceStatus: string
{
    case DataSourceStatusUnknown = 'DATA_SOURCE_STATUS_UNKNOWN';
    case DataSourceStatusInProgress = 'DATA_SOURCE_STATUS_IN_PROGRESS';
    case DataSourceStatusUpdated = 'DATA_SOURCE_STATUS_UPDATED';
    case DataSourceStatusPartiallyUpdated = 'DATA_SOURCE_STATUS_PARTIALLY_UPDATED';
    case DataSourceStatusNotUpdated = 'DATA_SOURCE_STATUS_NOT_UPDATED';
    case DataSourceStatusFailed = 'DATA_SOURCE_STATUS_FAILED';
    case DataSourceStatusCancelled = 'DATA_SOURCE_STATUS_CANCELLED';
}
