<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SuppressedResourceRoot
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\SuppressedResource> $resources
     */
    public function __construct(
        public ?SuppressedResourceRootLinks $links = null,
        public ?SuppressedResourceRootMeta $meta = null,
        public ?array $resources = null,
    ) {
    }
}
