<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum IssuesListForRepoState: string
{
    case Open = 'open';
    case Closed = 'closed';
    case All = 'all';
}
