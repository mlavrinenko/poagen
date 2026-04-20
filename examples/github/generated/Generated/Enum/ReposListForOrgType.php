<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForOrgType: string
{
    case All = 'all';
    case Public = 'public';
    case Private = 'private';
    case Forks = 'forks';
    case Sources = 'sources';
    case Member = 'member';
}
