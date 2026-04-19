<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryTransferredChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'owner' => ['owner', \Acme\GitHub\Generated\Model\WebhookRepositoryTransferredChangesOwner::class],
    ];

    public function __construct(
        public WebhookRepositoryTransferredChangesOwner $owner,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'owner' => $this->owner,
        ];
    }
}
