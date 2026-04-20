<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ClusterRegistry
{
    /**
     * @param ?list<string> $cluster_uuids
     */
    public function __construct(
        public ?array $cluster_uuids = null,
    ) {
    }
}
