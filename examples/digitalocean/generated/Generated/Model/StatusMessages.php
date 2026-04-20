<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class StatusMessages
{
    public function __construct(
        public ?string $message = null,
        public ?DateTimeImmutable $timestamp = null,
    ) {
    }
}
