<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgentTemplateGuardrail
{
    public function __construct(
        public ?int $priority = null,
        public ?string $uuid = null,
    ) {
    }
}
