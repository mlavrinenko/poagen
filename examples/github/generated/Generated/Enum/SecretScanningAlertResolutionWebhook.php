<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecretScanningAlertResolutionWebhook: string
{
    case FalsePositive = 'false_positive';
    case WontFix = 'wont_fix';
    case Revoked = 'revoked';
    case UsedInTests = 'used_in_tests';
    case PatternDeleted = 'pattern_deleted';
    case PatternEdited = 'pattern_edited';
}
