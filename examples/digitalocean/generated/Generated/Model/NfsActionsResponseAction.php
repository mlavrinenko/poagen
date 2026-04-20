<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class NfsActionsResponseAction
{
    public function __construct(
        public string $region_slug,
        public string $resource_id,
        public string $resource_type,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $type,
    ) {
    }
}
