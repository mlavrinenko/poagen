<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum IssuesListForOrgFilter: string
{
    case Assigned = 'assigned';
    case Created = 'created';
    case Mentioned = 'mentioned';
    case Subscribed = 'subscribed';
    case Repos = 'repos';
    case All = 'all';
}
