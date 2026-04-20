<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum OrgsListPendingInvitationsRole: string
{
    case All = 'all';
    case Admin = 'admin';
    case DirectMember = 'direct_member';
    case BillingManager = 'billing_manager';
    case HiringManager = 'hiring_manager';
}
