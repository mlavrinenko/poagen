<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForUserType: string
{
    case All = 'all';
    case Owner = 'owner';
    case Member = 'member';
}
