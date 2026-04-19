<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiLinkAgentGuardrailsInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuid' => ['agent_uuid', null],
        'guardrails' => ['guardrails', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentGuardrailInput::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentGuardrailInput> $guardrails
     */
    public function __construct(
        public ?string $agent_uuid = null,
        public ?array $guardrails = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuid' => $this->agent_uuid,
            'guardrails' => $this->guardrails,
        ];
    }
}
