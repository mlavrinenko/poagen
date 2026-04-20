<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AsyncInvokeResponse
{
    /**
     * @param ?array<string, mixed> $output
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $model_id,
        public string $request_id,
        public string $status,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $error = null,
        public ?array $output = null,
        public ?DateTimeImmutable $started_at = null,
    ) {
    }
}
