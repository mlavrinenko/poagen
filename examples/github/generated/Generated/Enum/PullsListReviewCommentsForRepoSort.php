<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum PullsListReviewCommentsForRepoSort: string
{
    case Created = 'created';
    case Updated = 'updated';
    case CreatedAt = 'created_at';
}
