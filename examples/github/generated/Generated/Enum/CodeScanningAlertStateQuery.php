<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningAlertStateQuery: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Dismissed = 'dismissed';
    case Fixed = 'fixed';
}
