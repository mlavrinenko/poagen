<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum EnabledRepositories: string
{
    case All = 'all';
    case None = 'none';
    case Selected = 'selected';
}
