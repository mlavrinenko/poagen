<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum ActionsListWorkflowRunsForRepoStatus: string
{
    case Completed = 'completed';
    case ActionRequired = 'action_required';
    case Cancelled = 'cancelled';
    case Failure = 'failure';
    case Neutral = 'neutral';
    case Skipped = 'skipped';
    case Stale = 'stale';
    case Success = 'success';
    case TimedOut = 'timed_out';
    case InProgress = 'in_progress';
    case Queued = 'queued';
    case Requested = 'requested';
    case Waiting = 'waiting';
    case Pending = 'pending';
}
