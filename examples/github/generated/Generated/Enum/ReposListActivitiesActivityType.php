<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ReposListActivitiesActivityType: string
{
    case Push = 'push';
    case ForcePush = 'force_push';
    case BranchCreation = 'branch_creation';
    case BranchDeletion = 'branch_deletion';
    case PrMerge = 'pr_merge';
    case MergeQueueMerge = 'merge_queue_merge';
}
