<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class VpcNatGatewayUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'size' => ['size', null],
        'icmp_timeout_seconds' => ['icmp_timeout_seconds', null],
        'tcp_timeout_seconds' => ['tcp_timeout_seconds', null],
        'udp_timeout_seconds' => ['udp_timeout_seconds', null],
        'vpcs' => ['vpcs', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $vpcs
     */
    public function __construct(
        public string $name,
        public int $size,
        public ?int $icmp_timeout_seconds = null,
        public ?int $tcp_timeout_seconds = null,
        public ?int $udp_timeout_seconds = null,
        public ?array $vpcs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'size' => $this->size,
            'icmp_timeout_seconds' => $this->icmp_timeout_seconds,
            'tcp_timeout_seconds' => $this->tcp_timeout_seconds,
            'udp_timeout_seconds' => $this->udp_timeout_seconds,
            'vpcs' => $this->vpcs,
        ];
    }
}
