<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookStatusCommitCommitVerification
{
    public function __construct(
        public ?string $payload = null,
        public string $reason,
        public ?string $signature = null,
        public bool $verified,
        public ?string $verified_at = null,
    ) {
    }
}
