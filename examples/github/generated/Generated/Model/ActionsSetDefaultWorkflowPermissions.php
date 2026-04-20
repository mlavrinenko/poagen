<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\ActionsDefaultWorkflowPermissions;

final readonly class ActionsSetDefaultWorkflowPermissions
{
    public function __construct(
        public ?ActionsCanApprovePullRequestReviews $can_approve_pull_request_reviews = null,
        public ?ActionsDefaultWorkflowPermissions $default_workflow_permissions = null,
    ) {
    }
}
