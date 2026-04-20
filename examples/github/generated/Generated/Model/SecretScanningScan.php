<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class SecretScanningScan
{
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?DateTimeImmutable $started_at = null,
        public ?string $status = null,
        public ?string $type = null,
    ) {
    }
}
