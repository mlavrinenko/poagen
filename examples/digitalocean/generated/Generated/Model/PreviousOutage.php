<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PreviousOutage
{
    public function __construct(
        public ?int $duration_seconds = null,
        public ?string $ended_at = null,
        public ?string $region = null,
        public ?string $started_at = null,
    ) {
    }
}
