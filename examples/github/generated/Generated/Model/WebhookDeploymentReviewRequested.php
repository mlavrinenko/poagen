<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentReviewRequested
{
    /**
     * @param list<array<string, mixed>> $reviewers
     */
    public function __construct(
        public string $action,
        public string $environment,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public WebhooksUser $requestor,
        public array $reviewers,
        public SimpleUser $sender,
        public string $since,
        public WebhookDeploymentReviewRequestedWorkflow_job_run $workflow_job_run,
        public WebhookDeploymentReviewRequestedWorkflow_run $workflow_run,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
