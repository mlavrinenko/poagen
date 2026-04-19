<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\InteractionGroup;
use DateTimeImmutable;
use JsonSerializable;

final readonly class InteractionLimitResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expires_at' => ['expires_at', ['datetime', null]],
        'limit' => ['limit', ['enum', \Acme\GitHub\Generated\Enum\InteractionGroup::class]],
        'origin' => ['origin', null],
    ];

    public function __construct(
        public DateTimeImmutable $expires_at,
        public InteractionGroup $limit,
        public string $origin,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expires_at' => $this->expires_at->format(\DateTimeInterface::RFC3339),
            'limit' => $this->limit,
            'origin' => $this->origin,
        ];
    }
}
