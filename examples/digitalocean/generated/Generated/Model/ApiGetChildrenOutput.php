<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiGetChildrenOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgent> $children
     */
    public function __construct(
        public ?array $children = null,
    ) {
    }
}
