<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Vpc implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'default' => ['default', null],
        'description' => ['description', null],
        'id' => ['id', null],
        'ip_range' => ['ip_range', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'urn' => ['urn', \Acme\DigitalOcean\Generated\Model\Urn2::class],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?bool $default = null,
        public ?string $description = null,
        public ?string $id = null,
        public ?string $ip_range = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?Urn2 $urn = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'default' => $this->default,
            'description' => $this->description,
            'id' => $this->id,
            'ip_range' => $this->ip_range,
            'name' => $this->name,
            'region' => $this->region,
            'urn' => $this->urn,
        ];
    }
}
