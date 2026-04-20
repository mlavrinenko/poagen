<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiLinkAgentGuardrailsInputPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentGuardrailInput> $guardrails
     */
    public function __construct(
        public ?string $agent_uuid = null,
        public ?array $guardrails = null,
    ) {
    }
}
