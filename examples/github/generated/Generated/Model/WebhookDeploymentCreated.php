<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentCreated
{
    public function __construct(
        public string $action,
        public WebhookDeploymentCreatedDeployment $deployment,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public WebhooksWorkflow $workflow,
        public WebhookDeploymentCreatedWorkflow_run $workflow_run,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
