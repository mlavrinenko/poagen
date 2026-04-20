<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsVpc
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsVpcEgressIp> $egress_ips
     */
    public function __construct(
        public ?array $egress_ips = null,
        public ?string $id = null,
    ) {
    }
}
