<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateAgentInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'anthropic_key_uuid' => ['anthropic_key_uuid', null],
        'description' => ['description', null],
        'instruction' => ['instruction', null],
        'knowledge_base_uuid' => ['knowledge_base_uuid', ['list', null]],
        'model_provider_key_uuid' => ['model_provider_key_uuid', null],
        'model_uuid' => ['model_uuid', null],
        'name' => ['name', null],
        'open_ai_key_uuid' => ['open_ai_key_uuid', null],
        'project_id' => ['project_id', null],
        'region' => ['region', null],
        'tags' => ['tags', ['list', null]],
        'workspace_uuid' => ['workspace_uuid', null],
    ];

    /**
     * @param ?list<string> $knowledge_base_uuid
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $anthropic_key_uuid = null,
        public ?string $description = null,
        public ?string $instruction = null,
        public ?array $knowledge_base_uuid = null,
        public ?string $model_provider_key_uuid = null,
        public ?string $model_uuid = null,
        public ?string $name = null,
        public ?string $open_ai_key_uuid = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?string $workspace_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'anthropic_key_uuid' => $this->anthropic_key_uuid,
            'description' => $this->description,
            'instruction' => $this->instruction,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
            'model_provider_key_uuid' => $this->model_provider_key_uuid,
            'model_uuid' => $this->model_uuid,
            'name' => $this->name,
            'open_ai_key_uuid' => $this->open_ai_key_uuid,
            'project_id' => $this->project_id,
            'region' => $this->region,
            'tags' => $this->tags,
            'workspace_uuid' => $this->workspace_uuid,
        ];
    }
}
