<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OnlineMigration
{
    public function __construct(
        public ?string $created_at = null,
        public ?string $id = null,
        public ?string $status = null,
    ) {
    }
}
