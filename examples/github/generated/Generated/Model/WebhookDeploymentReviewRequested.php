<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentReviewRequested implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'environment' => ['environment', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'requestor' => ['requestor', \Acme\GitHub\Generated\Model\WebhooksUser::class],
        'reviewers' => ['reviewers', ['list', null]],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'since' => ['since', null],
        'workflow_job_run' => [
            'workflow_job_run',
            \Acme\GitHub\Generated\Model\WebhookDeploymentReviewRequestedWorkflow_job_run::class,
        ],
        'workflow_run' => [
            'workflow_run',
            \Acme\GitHub\Generated\Model\WebhookDeploymentReviewRequestedWorkflow_run::class,
        ],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'environment' => $this->environment,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'requestor' => $this->requestor,
            'reviewers' => $this->reviewers,
            'sender' => $this->sender,
            'since' => $this->since,
            'workflow_job_run' => $this->workflow_job_run,
            'workflow_run' => $this->workflow_run,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
        ];
    }
}
