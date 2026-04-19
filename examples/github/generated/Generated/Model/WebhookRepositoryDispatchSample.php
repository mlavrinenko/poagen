<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryDispatchSample implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'branch' => ['branch', null],
        'client_payload' => ['client_payload', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    /**
     * @param ?array<string, mixed> $client_payload
     */
    public function __construct(
        public string $action,
        public string $branch,
        public ?array $client_payload = null,
        public SimpleInstallation $installation,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
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
            'branch' => $this->branch,
            'client_payload' => $this->client_payload,
            'installation' => $this->installation,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'organization' => $this->organization,
        ];
    }
}
