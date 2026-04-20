<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowJobWaiting
{
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public WebhookWorkflowJobWaitingWorkflow_job $workflow_job,
        public ?Deployment $deployment = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
