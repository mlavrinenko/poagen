<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookIssueDependenciesBlockingAdded implements JsonSerializable
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
        'blocked_issue' => ['blocked_issue', \Acme\GitHub\Generated\Model\Issue::class],
        'blocked_issue_id' => ['blocked_issue_id', null],
        'blocked_issue_repo' => ['blocked_issue_repo', \Acme\GitHub\Generated\Model\Repository::class],
        'blocking_issue' => ['blocking_issue', \Acme\GitHub\Generated\Model\Issue::class],
        'blocking_issue_id' => ['blocking_issue_id', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
    ];

    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?Issue $blocked_issue = null,
        public ?float $blocked_issue_id = null,
        public ?Repository $blocked_issue_repo = null,
        public ?Issue $blocking_issue = null,
        public ?float $blocking_issue_id = null,
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
            'organization' => $this->organization,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'blocked_issue' => $this->blocked_issue,
            'blocked_issue_id' => $this->blocked_issue_id,
            'blocked_issue_repo' => $this->blocked_issue_repo,
            'blocking_issue' => $this->blocking_issue,
            'blocking_issue_id' => $this->blocking_issue_id,
            'installation' => $this->installation,
        ];
    }
}
