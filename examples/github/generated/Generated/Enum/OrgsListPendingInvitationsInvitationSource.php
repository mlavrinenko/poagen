<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum OrgsListPendingInvitationsInvitationSource: string
{
    case All = 'all';
    case Member = 'member';
    case Scim = 'scim';
}
