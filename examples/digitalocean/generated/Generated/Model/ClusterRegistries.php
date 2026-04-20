<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ClusterRegistries
{
    /**
     * @param ?list<string> $cluster_uuids
     * @param ?list<string> $registries
     */
    public function __construct(
        public ?array $cluster_uuids = null,
        public ?array $registries = null,
    ) {
    }
}
