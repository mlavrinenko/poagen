<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum UsersGetContextForUserSubjectType: string
{
    case Organization = 'organization';
    case Repository = 'repository';
    case Issue = 'issue';
    case PullRequest = 'pull_request';
}
