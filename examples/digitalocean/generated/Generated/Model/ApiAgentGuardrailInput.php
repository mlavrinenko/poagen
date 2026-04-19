<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAgentGuardrailInput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['guardrail_uuid' => ['guardrail_uuid', null], 'priority' => ['priority', null]];

    public function __construct(
        public ?string $guardrail_uuid = null,
        public ?int $priority = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'guardrail_uuid' => $this->guardrail_uuid,
            'priority' => $this->priority,
        ];
    }
}
