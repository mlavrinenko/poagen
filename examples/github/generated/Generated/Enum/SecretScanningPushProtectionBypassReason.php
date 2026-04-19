<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecretScanningPushProtectionBypassReason: string
{
    case FalsePositive = 'false_positive';
    case UsedInTests = 'used_in_tests';
    case WillFixLater = 'will_fix_later';
}
