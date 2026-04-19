<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class FirewallRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'type' => ['type', null],
        'value' => ['value', null],
        'cluster_uuid' => ['cluster_uuid', null],
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public string $type,
        public string $value,
        public ?string $cluster_uuid = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'value' => $this->value,
            'cluster_uuid' => $this->cluster_uuid,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'uuid' => $this->uuid,
        ];
    }
}
