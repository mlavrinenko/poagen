<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksProjectChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archived_at' => ['archived_at', \Acme\GitHub\Generated\Model\WebhooksProjectChangesArchived_at::class],
    ];

    public function __construct(
        public ?WebhooksProjectChangesArchived_at $archived_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archived_at' => $this->archived_at,
        ];
    }
}
