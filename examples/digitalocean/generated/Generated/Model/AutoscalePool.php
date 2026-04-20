<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AutoscalePool
{
    public function __construct(
        public int $active_resources_count,
        public AutoscalePoolStaticConfig|AutoscalePoolDynamicConfig $config,
        public DateTimeImmutable $created_at,
        public AutoscalePoolDropletTemplate $droplet_template,
        public string $id,
        public string $name,
        public string $status,
        public DateTimeImmutable $updated_at,
        public ?CurrentUtilization $current_utilization = null,
    ) {
    }
}
