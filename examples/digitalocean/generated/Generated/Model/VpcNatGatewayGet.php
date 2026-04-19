<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class VpcNatGatewayGet implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'egresses' => ['egresses', \Acme\DigitalOcean\Generated\Model\VpcNatGatewayGetEgresses::class],
        'icmp_timeout_seconds' => ['icmp_timeout_seconds', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'state' => ['state', null],
        'tcp_timeout_seconds' => ['tcp_timeout_seconds', null],
        'type' => ['type', null],
        'udp_timeout_seconds' => ['udp_timeout_seconds', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vpcs' => ['vpcs', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $vpcs
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?VpcNatGatewayGetEgresses $egresses = null,
        public ?int $icmp_timeout_seconds = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?int $size = null,
        public ?string $state = null,
        public ?int $tcp_timeout_seconds = null,
        public ?string $type = null,
        public ?int $udp_timeout_seconds = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?array $vpcs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'egresses' => $this->egresses,
            'icmp_timeout_seconds' => $this->icmp_timeout_seconds,
            'id' => $this->id,
            'name' => $this->name,
            'region' => $this->region,
            'size' => $this->size,
            'state' => $this->state,
            'tcp_timeout_seconds' => $this->tcp_timeout_seconds,
            'type' => $this->type,
            'udp_timeout_seconds' => $this->udp_timeout_seconds,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'vpcs' => $this->vpcs,
        ];
    }
}
