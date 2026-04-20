<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseLayoutOption
{
    /**
     * @param ?list<string> $sizes
     */
    public function __construct(
        public ?int $num_nodes = null,
        public ?array $sizes = null,
    ) {
    }
}
