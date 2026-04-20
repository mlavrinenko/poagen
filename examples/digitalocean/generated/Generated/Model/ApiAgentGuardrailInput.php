<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgentGuardrailInput
{
    public function __construct(
        public ?string $guardrail_uuid = null,
        public ?int $priority = null,
    ) {
    }
}
