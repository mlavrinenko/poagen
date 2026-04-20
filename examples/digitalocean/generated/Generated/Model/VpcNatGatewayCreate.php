<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VpcNatGatewayCreate
{
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
}
