<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ReservedIpv6 implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'droplet' => ['droplet', null],
        'ip' => ['ip', null],
        'region_slug' => ['region_slug', null],
        'reserved_at' => ['reserved_at', ['datetime', null]],
    ];

    /**
     * @param ?mixed $droplet
     */
    public function __construct(
        public $droplet = null,
        public ?string $ip = null,
        public ?string $region_slug = null,
        public ?DateTimeImmutable $reserved_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'droplet' => $this->droplet,
            'ip' => $this->ip,
            'region_slug' => $this->region_slug,
            'reserved_at' => $this->reserved_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
