<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Multiregistry
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?int $storage_usage_bytes = null,
        public ?DateTimeImmutable $storage_usage_bytes_updated_at = null,
    ) {
    }
}
