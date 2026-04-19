<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecretScanningAlertResolution: string
{
    case FalsePositive = 'false_positive';
    case WontFix = 'wont_fix';
    case Revoked = 'revoked';
    case UsedInTests = 'used_in_tests';
}
