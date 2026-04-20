<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ChecksListForRefStatus: string
{
    case Queued = 'queued';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
