<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentStatusCreated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'deployment' => ['deployment', \Acme\GitHub\Generated\Model\WebhookDeploymentStatusCreatedDeployment::class],
        'deployment_status' => [
            'deployment_status',
            \Acme\GitHub\Generated\Model\WebhookDeploymentStatusCreatedDeployment_status::class,
        ],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'check_run' => ['check_run', \Acme\GitHub\Generated\Model\WebhookDeploymentStatusCreatedCheck_run::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'workflow' => ['workflow', \Acme\GitHub\Generated\Model\WebhooksWorkflow::class],
        'workflow_run' => ['workflow_run', \Acme\GitHub\Generated\Model\WebhookDeploymentStatusCreatedWorkflow_run::class],
    ];

    public function __construct(
        public string $action,
        public WebhookDeploymentStatusCreatedDeployment $deployment,
        public WebhookDeploymentStatusCreatedDeployment_status $deployment_status,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?WebhookDeploymentStatusCreatedCheck_run $check_run = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhooksWorkflow $workflow = null,
        public ?WebhookDeploymentStatusCreatedWorkflow_run $workflow_run = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'deployment' => $this->deployment,
            'deployment_status' => $this->deployment_status,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'check_run' => $this->check_run,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'workflow' => $this->workflow,
            'workflow_run' => $this->workflow_run,
        ];
    }
}
