<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsSnapshotListResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NfsSnapshotResponse> $snapshots
     */
    public function __construct(
        public ?array $snapshots = null,
    ) {
    }
}
