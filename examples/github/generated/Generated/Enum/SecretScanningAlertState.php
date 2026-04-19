<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecretScanningAlertState: string
{
    case Open = 'open';
    case Resolved = 'resolved';
}
