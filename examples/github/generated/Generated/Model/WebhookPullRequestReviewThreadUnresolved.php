<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPullRequestReviewThreadUnresolved implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'pull_request' => [
            'pull_request',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewThreadUnresolvedPull_request::class,
        ],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'thread' => ['thread', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewThreadUnresolvedThread::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public string $action,
        public WebhookPullRequestReviewThreadUnresolvedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewThreadUnresolvedThread $thread,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'pull_request' => $this->pull_request,
            'repository' => $this->repository,
            'thread' => $this->thread,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'sender' => $this->sender,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
