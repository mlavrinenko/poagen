<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiGuardrailType;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentGuardrail implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuid' => ['agent_uuid', null],
        'created_at' => ['created_at', ['datetime', null]],
        'default_response' => ['default_response', null],
        'description' => ['description', null],
        'guardrail_uuid' => ['guardrail_uuid', null],
        'is_attached' => ['is_attached', null],
        'is_default' => ['is_default', null],
        'metadata' => ['metadata', null],
        'name' => ['name', null],
        'priority' => ['priority', null],
        'type' => ['type', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiGuardrailType::class]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?array<string, mixed> $metadata
     */
    public function __construct(
        public ?string $agent_uuid = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $default_response = null,
        public ?string $description = null,
        public ?string $guardrail_uuid = null,
        public ?bool $is_attached = null,
        public ?bool $is_default = null,
        public ?array $metadata = null,
        public ?string $name = null,
        public ?int $priority = null,
        public ?ApiGuardrailType $type = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuid' => $this->agent_uuid,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'default_response' => $this->default_response,
            'description' => $this->description,
            'guardrail_uuid' => $this->guardrail_uuid,
            'is_attached' => $this->is_attached,
            'is_default' => $this->is_default,
            'metadata' => $this->metadata,
            'name' => $this->name,
            'priority' => $this->priority,
            'type' => $this->type,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
