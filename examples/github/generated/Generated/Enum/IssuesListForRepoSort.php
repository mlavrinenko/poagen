<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum IssuesListForRepoSort: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Comments = 'comments';
}
