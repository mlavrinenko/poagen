<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Domain implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ip_address' => ['ip_address', null],
        'name' => ['name', null],
        'ttl' => ['ttl', null],
        'zone_file' => ['zone_file', null],
    ];

    public function __construct(
        public ?string $ip_address = null,
        public ?string $name = null,
        public ?int $ttl = null,
        public ?string $zone_file = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ip_address' => $this->ip_address,
            'name' => $this->name,
            'ttl' => $this->ttl,
            'zone_file' => $this->zone_file,
        ];
    }
}
