<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ConnectionPools
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ConnectionPool> $pools
     */
    public function __construct(
        public ?array $pools = null,
    ) {
    }
}
