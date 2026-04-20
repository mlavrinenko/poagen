<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DestroyedAssociatedResource
{
    public function __construct(
        public ?DateTimeImmutable $destroyed_at = null,
        public ?string $error_message = null,
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }
}
