<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DestroyAssociatedKubernetesResources
{
    /**
     * @param ?list<string> $load_balancers
     * @param ?list<string> $volume_snapshots
     * @param ?list<string> $volumes
     */
    public function __construct(
        public ?array $load_balancers = null,
        public ?array $volume_snapshots = null,
        public ?array $volumes = null,
    ) {
    }
}
