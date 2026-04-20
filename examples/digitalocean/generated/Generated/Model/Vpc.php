<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Vpc
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?bool $default = null,
        public ?string $description = null,
        public ?string $id = null,
        public ?string $ip_range = null,
        public ?string $name = null,
        public ?string $region = null,
        public ?Urn2 $urn = null,
    ) {
    }
}
