<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseStorageAutoscaleParams
{
    public function __construct(
        public bool $enabled,
        public ?int $increment_gib = null,
        public ?int $threshold_percent = null,
    ) {
    }
}
