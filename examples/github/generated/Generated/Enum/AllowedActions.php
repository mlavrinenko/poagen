<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum AllowedActions: string
{
    case All = 'all';
    case LocalOnly = 'local_only';
    case Selected = 'selected';
}
