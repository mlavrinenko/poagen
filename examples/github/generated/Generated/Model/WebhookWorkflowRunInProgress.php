<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowRunInProgress
{
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public WebhooksWorkflow $workflow,
        public WebhookWorkflowRunInProgressWorkflow_run $workflow_run,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
