<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningAlertClassification: string
{
    case Source = 'source';
    case Generated = 'generated';
    case Test = 'test';
    case Library = 'library';
}
