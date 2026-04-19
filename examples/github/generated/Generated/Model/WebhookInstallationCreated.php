<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookInstallationCreated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\Installation::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repositories' => ['repositories', \Acme\GitHub\Generated\Model\WebhooksRepositories::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'requester' => ['requester', \Acme\GitHub\Generated\Model\WebhooksUser::class],
    ];

    public function __construct(
        public string $action,
        public Installation $installation,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhooksRepositories $repositories = null,
        public ?RepositoryWebhooks $repository = null,
        public ?WebhooksUser $requester = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'installation' => $this->installation,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'organization' => $this->organization,
            'repositories' => $this->repositories,
            'repository' => $this->repository,
            'requester' => $this->requester,
        ];
    }
}
