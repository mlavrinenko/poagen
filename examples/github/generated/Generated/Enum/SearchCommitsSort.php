<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum SearchCommitsSort: string
{
    case AuthorDate = 'author-date';
    case CommitterDate = 'committer-date';
}
