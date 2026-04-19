<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryTransferredChangesOwnerFrom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'organization' => [
            'organization',
            \Acme\GitHub\Generated\Model\WebhookRepositoryTransferredChangesOwnerFromOrganization::class,
        ],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookRepositoryTransferredChangesOwnerFromUser::class],
    ];

    public function __construct(
        public ?WebhookRepositoryTransferredChangesOwnerFromOrganization $organization = null,
        public ?WebhookRepositoryTransferredChangesOwnerFromUser $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'organization' => $this->organization,
            'user' => $this->user,
        ];
    }
}
