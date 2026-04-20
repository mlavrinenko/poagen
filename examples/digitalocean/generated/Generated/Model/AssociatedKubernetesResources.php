<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AssociatedKubernetesResources
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AssociatedKubernetesResource> $load_balancers
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AssociatedKubernetesResource> $volume_snapshots
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AssociatedKubernetesResource> $volumes
     */
    public function __construct(
        public ?array $load_balancers = null,
        public ?array $volume_snapshots = null,
        public ?array $volumes = null,
    ) {
    }
}
