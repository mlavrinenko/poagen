<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ReservedIpv6List
{
    /**
     * @param ?list<mixed> $reserved_ipv6s
     */
    public function __construct(
        public ?array $reserved_ipv6s = null,
    ) {
    }
}
