<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FileCommitCommitVerification
{
    public function __construct(
        public ?string $payload = null,
        public ?string $reason = null,
        public ?string $signature = null,
        public ?bool $verified = null,
        public ?string $verified_at = null,
    ) {
    }
}
