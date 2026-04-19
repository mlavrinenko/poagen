<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestReviewDismissed implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'pull_request' => [
            'pull_request',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewDismissedPull_request::class,
        ],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'review' => ['review', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewDismissedReview::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public WebhookPullRequestReviewDismissedPull_request $pull_request,
        public RepositoryWebhooks $repository,
        public WebhookPullRequestReviewDismissedReview $review,
        public SimpleUser $sender,
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
            'pull_request' => $this->pull_request,
            'repository' => $this->repository,
            'review' => $this->review,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
        ];
    }
}
