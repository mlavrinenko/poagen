<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestEdited implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'changes' => ['changes', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChanges::class],
        'number' => ['number', \Acme\GitHub\Generated\Model\WebhooksNumber::class],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\PullRequestWebhook::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public string $action,
        public WebhookPullRequestEditedChanges $changes,
        public WebhooksNumber $number,
        public PullRequestWebhook $pull_request,
        public RepositoryWebhooks $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
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
            'changes' => $this->changes,
            'number' => $this->number,
            'pull_request' => $this->pull_request,
            'repository' => $this->repository,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'sender' => $this->sender,
        ];
    }
}
