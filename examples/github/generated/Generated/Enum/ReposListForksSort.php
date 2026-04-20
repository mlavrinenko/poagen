<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListForksSort: string
{
    case Newest = 'newest';
    case Oldest = 'oldest';
    case Stargazers = 'stargazers';
    case Watchers = 'watchers';
}
