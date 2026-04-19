<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookSponsorshipCreated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'sponsorship' => ['sponsorship', \Acme\GitHub\Generated\Model\WebhooksSponsorship::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public SimpleUser $sender,
        public WebhooksSponsorship $sponsorship,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'sender' => $this->sender,
            'sponsorship' => $this->sponsorship,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'repository' => $this->repository,
        ];
    }
}
