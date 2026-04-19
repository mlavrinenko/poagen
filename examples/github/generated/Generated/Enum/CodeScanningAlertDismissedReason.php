<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningAlertDismissedReason: string
{
    case FalsePositive = 'false positive';
    case WonTFix = 'won\'t fix';
    case UsedInTests = 'used in tests';
}
