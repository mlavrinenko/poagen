<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VpcNatGatewayGetEgresses
{
    /**
     * @param ?list<array<string, mixed>> $public_gateways
     */
    public function __construct(
        public ?array $public_gateways = null,
    ) {
    }
}
