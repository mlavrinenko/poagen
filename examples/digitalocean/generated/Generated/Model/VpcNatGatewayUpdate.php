<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VpcNatGatewayUpdate
{
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
}
