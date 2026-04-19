<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ProjectsV2ItemContentType: string
{
    case Issue = 'Issue';
    case PullRequest = 'PullRequest';
    case DraftIssue = 'DraftIssue';
}
