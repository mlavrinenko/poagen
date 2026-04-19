<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use JsonSerializable;

final readonly class ApiUpdateAgentInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_log_insights_enabled' => ['agent_log_insights_enabled', null],
        'allowed_domains' => ['allowed_domains', ['list', null]],
        'anthropic_key_uuid' => ['anthropic_key_uuid', null],
        'conversation_logs_enabled' => ['conversation_logs_enabled', null],
        'description' => ['description', null],
        'instruction' => ['instruction', null],
        'k' => ['k', null],
        'max_tokens' => ['max_tokens', null],
        'model_provider_key_uuid' => ['model_provider_key_uuid', null],
        'model_uuid' => ['model_uuid', null],
        'name' => ['name', null],
        'open_ai_key_uuid' => ['open_ai_key_uuid', null],
        'project_id' => ['project_id', null],
        'provide_citations' => ['provide_citations', null],
        'retrieval_method' => ['retrieval_method', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod::class]],
        'tags' => ['tags', ['list', null]],
        'temperature' => ['temperature', null],
        'top_p' => ['top_p', null],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?list<string> $allowed_domains
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?bool $agent_log_insights_enabled = null,
        public ?array $allowed_domains = null,
        public ?string $anthropic_key_uuid = null,
        public ?bool $conversation_logs_enabled = null,
        public ?string $description = null,
        public ?string $instruction = null,
        public ?int $k = null,
        public ?int $max_tokens = null,
        public ?string $model_provider_key_uuid = null,
        public ?string $model_uuid = null,
        public ?string $name = null,
        public ?string $open_ai_key_uuid = null,
        public ?string $project_id = null,
        public ?bool $provide_citations = null,
        public ?ApiRetrievalMethod $retrieval_method = null,
        public ?array $tags = null,
        public ?float $temperature = null,
        public ?float $top_p = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_log_insights_enabled' => $this->agent_log_insights_enabled,
            'allowed_domains' => $this->allowed_domains,
            'anthropic_key_uuid' => $this->anthropic_key_uuid,
            'conversation_logs_enabled' => $this->conversation_logs_enabled,
            'description' => $this->description,
            'instruction' => $this->instruction,
            'k' => $this->k,
            'max_tokens' => $this->max_tokens,
            'model_provider_key_uuid' => $this->model_provider_key_uuid,
            'model_uuid' => $this->model_uuid,
            'name' => $this->name,
            'open_ai_key_uuid' => $this->open_ai_key_uuid,
            'project_id' => $this->project_id,
            'provide_citations' => $this->provide_citations,
            'retrieval_method' => $this->retrieval_method,
            'tags' => $this->tags,
            'temperature' => $this->temperature,
            'top_p' => $this->top_p,
            'uuid' => $this->uuid,
        ];
    }
}
