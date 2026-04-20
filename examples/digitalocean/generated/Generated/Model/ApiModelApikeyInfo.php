<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiModelApikeyInfo
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $name = null,
        public ?string $secret_key = null,
        public ?string $uuid = null,
    ) {
    }
}
