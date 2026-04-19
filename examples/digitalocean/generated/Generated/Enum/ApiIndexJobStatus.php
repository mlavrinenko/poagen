<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiIndexJobStatus: string
{
    case IndexJobStatusUnknown = 'INDEX_JOB_STATUS_UNKNOWN';
    case IndexJobStatusPartial = 'INDEX_JOB_STATUS_PARTIAL';
    case IndexJobStatusInProgress = 'INDEX_JOB_STATUS_IN_PROGRESS';
    case IndexJobStatusCompleted = 'INDEX_JOB_STATUS_COMPLETED';
    case IndexJobStatusFailed = 'INDEX_JOB_STATUS_FAILED';
    case IndexJobStatusNoChanges = 'INDEX_JOB_STATUS_NO_CHANGES';
    case IndexJobStatusPending = 'INDEX_JOB_STATUS_PENDING';
    case IndexJobStatusCancelled = 'INDEX_JOB_STATUS_CANCELLED';
}
