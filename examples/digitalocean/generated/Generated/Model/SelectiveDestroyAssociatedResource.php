<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SelectiveDestroyAssociatedResource
{
    /**
     * @param ?list<string> $floating_ips
     * @param ?list<string> $reserved_ips
     * @param ?list<string> $snapshots
     * @param ?list<string> $volume_snapshots
     * @param ?list<string> $volumes
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
