<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DedicatedInferenceAccelerator
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $role = null,
        public ?string $slug = null,
        public ?string $status = null,
    ) {
    }
}
