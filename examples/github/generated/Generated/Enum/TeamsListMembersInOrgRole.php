<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum TeamsListMembersInOrgRole: string
{
    case Member = 'member';
    case Maintainer = 'maintainer';
    case All = 'all';
}
