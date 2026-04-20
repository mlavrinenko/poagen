<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AccessKey
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?DateTimeImmutable $expires_at = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
