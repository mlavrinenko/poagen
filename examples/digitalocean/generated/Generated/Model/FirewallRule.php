<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class FirewallRule
{
    public function __construct(
        public string $type,
        public string $value,
        public ?string $cluster_uuid = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $uuid = null,
    ) {
    }
}
