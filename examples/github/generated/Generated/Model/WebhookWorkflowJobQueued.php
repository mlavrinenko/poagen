<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookWorkflowJobQueued implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'workflow_job' => ['workflow_job', \Acme\GitHub\Generated\Model\WebhookWorkflowJobQueuedWorkflow_job::class],
        'deployment' => ['deployment', \Acme\GitHub\Generated\Model\Deployment::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public WebhookWorkflowJobQueuedWorkflow_job $workflow_job,
        public ?Deployment $deployment = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'workflow_job' => $this->workflow_job,
            'deployment' => $this->deployment,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
        ];
    }
}
