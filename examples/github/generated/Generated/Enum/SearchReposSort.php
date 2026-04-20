<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SearchReposSort: string
{
    case Stars = 'stars';
    case Forks = 'forks';
    case HelpWantedIssues = 'help-wanted-issues';
    case Updated = 'updated';
}
