<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceCreateRequest
{
    /**
     * @param ?array<string, string> $access_tokens
     */
    public function __construct(
        public DedicatedInferenceSpec $spec,
        public ?array $access_tokens = null,
    ) {
    }
}
