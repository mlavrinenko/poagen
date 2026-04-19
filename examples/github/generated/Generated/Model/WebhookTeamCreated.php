<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookTeamCreated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'team' => ['team', \Acme\GitHub\Generated\Model\WebhooksTeam1::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\WebhookTeamCreatedRepository::class],
    ];

    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public SimpleUser $sender,
        public WebhooksTeam1 $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?WebhookTeamCreatedRepository $repository = null,
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
            'sender' => $this->sender,
            'team' => $this->team,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'repository' => $this->repository,
        ];
    }
}
