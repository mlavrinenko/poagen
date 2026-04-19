<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksMembership implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'organization_url' => ['organization_url', null],
        'role' => ['role', null],
        'state' => ['state', null],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhooksMembershipUser::class],
        'direct_membership' => ['direct_membership', null],
        'enterprise_teams_providing_indirect_membership' => [
            'enterprise_teams_providing_indirect_membership',
            ['list', null],
        ],
    ];

    /**
     * @param ?list<string> $enterprise_teams_providing_indirect_membership
     */
    public function __construct(
        public string $organization_url,
        public string $role,
        public string $state,
        public string $url,
        public WebhooksMembershipUser $user,
        public ?bool $direct_membership = null,
        public ?array $enterprise_teams_providing_indirect_membership = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'organization_url' => $this->organization_url,
            'role' => $this->role,
            'state' => $this->state,
            'url' => $this->url,
            'user' => $this->user,
            'direct_membership' => $this->direct_membership,
            'enterprise_teams_providing_indirect_membership' => $this->enterprise_teams_providing_indirect_membership,
        ];
    }
}
