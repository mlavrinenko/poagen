<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ProjectAssignment
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Urn> $resources
     */
    public function __construct(
        public ?array $resources = null,
    ) {
    }
}
