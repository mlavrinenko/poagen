<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AssociatedResourceStatusResources
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $floating_ips
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $reserved_ips
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $snapshots
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $volume_snapshots
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource> $volumes
     */
    public function __construct(
        public ?array $floating_ips = null,
        public ?array $reserved_ips = null,
        public ?array $snapshots = null,
        public ?array $volume_snapshots = null,
        public ?array $volumes = null,
    ) {
    }
}
