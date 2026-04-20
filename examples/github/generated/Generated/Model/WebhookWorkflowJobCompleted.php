<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookWorkflowJobCompleted
{
    /**
     * @param mixed $workflow_job
     */
    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public $workflow_job,
        public ?Deployment $deployment = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
