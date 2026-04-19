<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Member implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'current_utilization' => [
            'current_utilization',
            \Acme\DigitalOcean\Generated\Model\MemberCurrentUtilization::class,
        ],
        'droplet_id' => ['droplet_id', null],
        'health_status' => ['health_status', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public MemberCurrentUtilization $current_utilization,
        public int $droplet_id,
        public string $health_status,
        public string $status,
        public DateTimeImmutable $updated_at,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'current_utilization' => $this->current_utilization,
            'droplet_id' => $this->droplet_id,
            'health_status' => $this->health_status,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
        ];
    }
}
