<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class VolumeAction
{
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?int $id = null,
        public ?Region $region = null,
        public ?string $region_slug = null,
        public ?int $resource_id = null,
        public ?string $resource_type = null,
        public ?DateTimeImmutable $started_at = null,
        public ?string $status = null,
        public ?string $type = null,
    ) {
    }
}
