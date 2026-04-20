<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletNetworks
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NetworkV4> $v4
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NetworkV6> $v6
     */
    public function __construct(
        public ?array $v4 = null,
        public ?array $v6 = null,
    ) {
    }
}
