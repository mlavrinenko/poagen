<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class VpcNatGatewayGet
{
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
}
