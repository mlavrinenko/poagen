<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentReviewApproved
{
    /**
     * @param ?list<array<string, mixed>> $workflow_job_runs
     */
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public string $since,
        public WebhookDeploymentReviewApprovedWorkflow_run $workflow_run,
        public ?WebhooksApprover $approver = null,
        public ?string $comment = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhooksReviewers $reviewers = null,
        public ?WebhooksWorkflowJobRun $workflow_job_run = null,
        public ?array $workflow_job_runs = null,
    ) {
    }
}
