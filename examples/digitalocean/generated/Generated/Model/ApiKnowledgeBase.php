<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiKnowledgeBase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'added_to_agent_at' => ['added_to_agent_at', ['datetime', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'database_id' => ['database_id', null],
        'embedding_model_uuid' => ['embedding_model_uuid', null],
        'is_public' => ['is_public', null],
        'last_indexing_job' => ['last_indexing_job', \Acme\DigitalOcean\Generated\Model\ApiIndexingJob::class],
        'name' => ['name', null],
        'project_id' => ['project_id', null],
        'region' => ['region', null],
        'tags' => ['tags', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'user_id' => ['user_id', null],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?DateTimeImmutable $added_to_agent_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $database_id = null,
        public ?string $embedding_model_uuid = null,
        public ?bool $is_public = null,
        public ?ApiIndexingJob $last_indexing_job = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $user_id = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'added_to_agent_at' => $this->added_to_agent_at?->format(\DateTimeInterface::RFC3339),
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'database_id' => $this->database_id,
            'embedding_model_uuid' => $this->embedding_model_uuid,
            'is_public' => $this->is_public,
            'last_indexing_job' => $this->last_indexing_job,
            'name' => $this->name,
            'project_id' => $this->project_id,
            'region' => $this->region,
            'tags' => $this->tags,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'user_id' => $this->user_id,
            'uuid' => $this->uuid,
        ];
    }
}
