<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SinksResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\SinkResource> $resources
     */
    public function __construct(
        public ?Destination $destination = null,
        public ?array $resources = null,
    ) {
    }
}
