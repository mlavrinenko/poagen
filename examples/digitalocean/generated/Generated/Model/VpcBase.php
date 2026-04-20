<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class VpcBase
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?Urn2 $urn = null,
    ) {
    }
}
