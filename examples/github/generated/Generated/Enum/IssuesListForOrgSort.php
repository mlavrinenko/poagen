<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum IssuesListForOrgSort: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Comments = 'comments';
}
