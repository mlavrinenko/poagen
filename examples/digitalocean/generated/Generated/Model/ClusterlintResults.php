<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ClusterlintResults
{
    /**
     * @param ?list<array<string, mixed>> $diagnostics
     */
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?array $diagnostics = null,
        public ?DateTimeImmutable $requested_at = null,
        public ?string $run_id = null,
    ) {
    }
}
