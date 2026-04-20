<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NeighborIds
{
    /**
     * @param ?list<list<int>> $neighbor_ids
     */
    public function __construct(
        public ?array $neighbor_ids = null,
    ) {
    }
}
