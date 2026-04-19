<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentReviewRejected implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'since' => ['since', null],
        'workflow_run' => ['workflow_run', \Acme\GitHub\Generated\Model\WebhookDeploymentReviewRejectedWorkflow_run::class],
        'approver' => ['approver', \Acme\GitHub\Generated\Model\WebhooksApprover::class],
        'comment' => ['comment', null],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'reviewers' => ['reviewers', \Acme\GitHub\Generated\Model\WebhooksReviewers::class],
        'workflow_job_run' => ['workflow_job_run', \Acme\GitHub\Generated\Model\WebhooksWorkflowJobRun::class],
        'workflow_job_runs' => ['workflow_job_runs', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $workflow_job_runs
     */
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public string $since,
        public WebhookDeploymentReviewRejectedWorkflow_run $workflow_run,
        public ?WebhooksApprover $approver = null,
        public ?string $comment = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhooksReviewers $reviewers = null,
        public ?WebhooksWorkflowJobRun $workflow_job_run = null,
        public ?array $workflow_job_runs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'since' => $this->since,
            'workflow_run' => $this->workflow_run,
            'approver' => $this->approver,
            'comment' => $this->comment,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'reviewers' => $this->reviewers,
            'workflow_job_run' => $this->workflow_job_run,
            'workflow_job_runs' => $this->workflow_job_runs,
        ];
    }
}
