<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Resource
{
    public function __construct(
        public ?DateTimeImmutable $assigned_at = null,
        public ?ResourceLinks $links = null,
        public ?string $status = null,
        public ?Urn $urn = null,
    ) {
    }
}
