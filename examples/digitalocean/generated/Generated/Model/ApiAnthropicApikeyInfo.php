<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiAnthropicApikeyInfo
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $name = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }
}
