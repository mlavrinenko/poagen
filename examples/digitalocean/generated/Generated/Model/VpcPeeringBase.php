<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class VpcPeeringBase
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $status = null,
    ) {
    }
}
