<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningAutofixStatus: string
{
    case Pending = 'pending';
    case Error = 'error';
    case Success = 'success';
    case Outdated = 'outdated';
}
