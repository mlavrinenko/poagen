<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookSecretScanningAlertLocationCreated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alert' => ['alert', \Acme\GitHub\Generated\Model\SecretScanningAlertWebhook::class],
        'location' => ['location', \Acme\GitHub\Generated\Model\SecretScanningLocation::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'action' => ['action', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    public function __construct(
        public SecretScanningAlertWebhook $alert,
        public SecretScanningLocation $location,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?string $action = null,
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
            'alert' => $this->alert,
            'location' => $this->location,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'action' => $this->action,
            'installation' => $this->installation,
            'organization' => $this->organization,
        ];
    }
}
