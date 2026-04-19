<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningAlertState: string
{
    case Open = 'open';
    case Dismissed = 'dismissed';
    case Fixed = 'fixed';
}
