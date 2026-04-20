<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DedicatedInferenceAccessToken
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?bool $is_managed = null,
        public ?string $name = null,
        public ?string $value = null,
    ) {
    }
}
