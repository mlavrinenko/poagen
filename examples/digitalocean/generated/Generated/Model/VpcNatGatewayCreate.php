<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class VpcNatGatewayCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'type' => ['type', null],
        'vpcs' => ['vpcs', ['list', null]],
        'icmp_timeout_seconds' => ['icmp_timeout_seconds', null],
        'tcp_timeout_seconds' => ['tcp_timeout_seconds', null],
        'udp_timeout_seconds' => ['udp_timeout_seconds', null],
    ];

    /**
     * @param list<array<string, mixed>> $vpcs
     */
    public function __construct(
        public string $name,
        public string $region,
        public int $size,
        public string $type,
        public array $vpcs,
        public ?int $icmp_timeout_seconds = null,
        public ?int $tcp_timeout_seconds = null,
        public ?int $udp_timeout_seconds = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'region' => $this->region,
            'size' => $this->size,
            'type' => $this->type,
            'vpcs' => $this->vpcs,
            'icmp_timeout_seconds' => $this->icmp_timeout_seconds,
            'tcp_timeout_seconds' => $this->tcp_timeout_seconds,
            'udp_timeout_seconds' => $this->udp_timeout_seconds,
        ];
    }
}
