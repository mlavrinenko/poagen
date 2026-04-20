<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForUserSort: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Pushed = 'pushed';
    case FullName = 'full_name';
}
