<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookSubIssuesSubIssueRemoved implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'parent_issue' => ['parent_issue', \Acme\GitHub\Generated\Model\Issue::class],
        'parent_issue_id' => ['parent_issue_id', null],
        'sub_issue' => ['sub_issue', \Acme\GitHub\Generated\Model\Issue::class],
        'sub_issue_id' => ['sub_issue_id', null],
        'sub_issue_repo' => ['sub_issue_repo', \Acme\GitHub\Generated\Model\Repository::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public string $action,
        public Issue $parent_issue,
        public float $parent_issue_id,
        public Issue $sub_issue,
        public float $sub_issue_id,
        public Repository $sub_issue_repo,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'parent_issue' => $this->parent_issue,
            'parent_issue_id' => $this->parent_issue_id,
            'sub_issue' => $this->sub_issue,
            'sub_issue_id' => $this->sub_issue_id,
            'sub_issue_repo' => $this->sub_issue_repo,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'sender' => $this->sender,
        ];
    }
}
