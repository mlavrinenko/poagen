<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum TeamsListMembersLegacyRole: string
{
    case Member = 'member';
    case Maintainer = 'maintainer';
    case All = 'all';
}
