<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum RepositoryRuleEnforcement: string
{
    case Disabled = 'disabled';
    case Active = 'active';
    case Evaluate = 'evaluate';
}
