<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateKnowledgeBaseInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'database_id' => ['database_id', null],
        'datasources' => ['datasources', ['list', \Acme\DigitalOcean\Generated\Model\ApiKbdataSource::class]],
        'embedding_model_uuid' => ['embedding_model_uuid', null],
        'name' => ['name', null],
        'project_id' => ['project_id', null],
        'region' => ['region', null],
        'tags' => ['tags', ['list', null]],
        'vpc_uuid' => ['vpc_uuid', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKbdataSource> $datasources
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $database_id = null,
        public ?array $datasources = null,
        public ?string $embedding_model_uuid = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?string $vpc_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'database_id' => $this->database_id,
            'datasources' => $this->datasources,
            'embedding_model_uuid' => $this->embedding_model_uuid,
            'name' => $this->name,
            'project_id' => $this->project_id,
            'region' => $this->region,
            'tags' => $this->tags,
            'vpc_uuid' => $this->vpc_uuid,
        ];
    }
}
