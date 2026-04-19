<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMembershipAdded implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'member' => ['member', \Acme\GitHub\Generated\Model\WebhooksUser::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'scope' => ['scope', null],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\WebhookMembershipAddedSender::class],
        'team' => ['team', \Acme\GitHub\Generated\Model\WebhooksTeam::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public WebhooksUser $member,
        public OrganizationSimpleWebhooks $organization,
        public string $scope,
        public WebhookMembershipAddedSender $sender,
        public WebhooksTeam $team,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
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
            'member' => $this->member,
            'organization' => $this->organization,
            'scope' => $this->scope,
            'sender' => $this->sender,
            'team' => $this->team,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'repository' => $this->repository,
        ];
    }
}
