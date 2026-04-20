<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SecretScanningListAlertsForRepoState: string
{
    case Open = 'open';
    case Resolved = 'resolved';
}
