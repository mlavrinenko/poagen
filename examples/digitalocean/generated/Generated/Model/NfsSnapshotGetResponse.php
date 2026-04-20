<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsSnapshotGetResponse
{
    public function __construct(
        public ?NfsSnapshotResponse $snapshot = null,
    ) {
    }
}
