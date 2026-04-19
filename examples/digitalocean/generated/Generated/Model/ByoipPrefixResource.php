<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ByoipPrefixResource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assigned_at' => ['assigned_at', ['datetime', null]],
        'byoip' => ['byoip', null],
        'id' => ['id', null],
        'region' => ['region', null],
        'resource' => ['resource', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $assigned_at = null,
        public ?string $byoip = null,
        public ?int $id = null,
        public ?string $region = null,
        public ?string $resource = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assigned_at' => $this->assigned_at?->format(\DateTimeInterface::RFC3339),
            'byoip' => $this->byoip,
            'id' => $this->id,
            'region' => $this->region,
            'resource' => $this->resource,
        ];
    }
}
