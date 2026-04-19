<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuid' => ['agent_uuid', null],
        'attached_child_agents' => [
            'attached_child_agents',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentChildRelationshipVerion::class],
        ],
        'attached_functions' => [
            'attached_functions',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentFunctionVersion::class],
        ],
        'attached_guardrails' => [
            'attached_guardrails',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentGuardrailVersion::class],
        ],
        'attached_knowledgebases' => [
            'attached_knowledgebases',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentKnowledgeBaseVersion::class],
        ],
        'can_rollback' => ['can_rollback', null],
        'created_at' => ['created_at', ['datetime', null]],
        'created_by_email' => ['created_by_email', null],
        'currently_applied' => ['currently_applied', null],
        'description' => ['description', null],
        'id' => ['id', null],
        'instruction' => ['instruction', null],
        'k' => ['k', null],
        'max_tokens' => ['max_tokens', null],
        'model_name' => ['model_name', null],
        'name' => ['name', null],
        'provide_citations' => ['provide_citations', null],
        'retrieval_method' => ['retrieval_method', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod::class]],
        'tags' => ['tags', ['list', null]],
        'temperature' => ['temperature', null],
        'top_p' => ['top_p', null],
        'trigger_action' => ['trigger_action', null],
        'version_hash' => ['version_hash', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentChildRelationshipVerion> $attached_child_agents
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentFunctionVersion> $attached_functions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentGuardrailVersion> $attached_guardrails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentKnowledgeBaseVersion> $attached_knowledgebases
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $agent_uuid = null,
        public ?array $attached_child_agents = null,
        public ?array $attached_functions = null,
        public ?array $attached_guardrails = null,
        public ?array $attached_knowledgebases = null,
        public ?bool $can_rollback = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by_email = null,
        public ?bool $currently_applied = null,
        public ?string $description = null,
        public ?string $id = null,
        public ?string $instruction = null,
        public ?int $k = null,
        public ?int $max_tokens = null,
        public ?string $model_name = null,
        public ?string $name = null,
        public ?bool $provide_citations = null,
        public ?ApiRetrievalMethod $retrieval_method = null,
        public ?array $tags = null,
        public ?float $temperature = null,
        public ?float $top_p = null,
        public ?string $trigger_action = null,
        public ?string $version_hash = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuid' => $this->agent_uuid,
            'attached_child_agents' => $this->attached_child_agents,
            'attached_functions' => $this->attached_functions,
            'attached_guardrails' => $this->attached_guardrails,
            'attached_knowledgebases' => $this->attached_knowledgebases,
            'can_rollback' => $this->can_rollback,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'created_by_email' => $this->created_by_email,
            'currently_applied' => $this->currently_applied,
            'description' => $this->description,
            'id' => $this->id,
            'instruction' => $this->instruction,
            'k' => $this->k,
            'max_tokens' => $this->max_tokens,
            'model_name' => $this->model_name,
            'name' => $this->name,
            'provide_citations' => $this->provide_citations,
            'retrieval_method' => $this->retrieval_method,
            'tags' => $this->tags,
            'temperature' => $this->temperature,
            'top_p' => $this->top_p,
            'trigger_action' => $this->trigger_action,
            'version_hash' => $this->version_hash,
        ];
    }
}
