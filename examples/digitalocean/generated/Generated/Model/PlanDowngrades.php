<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PlanDowngrades implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'effective_at' => ['effective_at', ['datetime', null]],
        'resources' => ['resources', ['list', null]],
    ];

    /**
     * @param ?list<string> $resources
     */
    public function __construct(
        public ?DateTimeImmutable $effective_at = null,
        public ?array $resources = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'effective_at' => $this->effective_at?->format(\DateTimeInterface::RFC3339),
            'resources' => $this->resources,
        ];
    }
}
