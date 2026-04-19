<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2Field implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'data_type' => ['data_type', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'project_url' => ['project_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'configuration' => ['configuration', \Acme\GitHub\Generated\Model\ProjectsV2FieldConfiguration::class],
        'issue_field_id' => ['issue_field_id', null],
        'node_id' => ['node_id', null],
        'options' => ['options', ['list', \Acme\GitHub\Generated\Model\ProjectsV2SingleSelectOptions::class]],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\ProjectsV2SingleSelectOptions> $options
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $data_type,
        public int $id,
        public string $name,
        public string $project_url,
        public DateTimeImmutable $updated_at,
        public ?ProjectsV2FieldConfiguration $configuration = null,
        public ?int $issue_field_id = null,
        public ?string $node_id = null,
        public ?array $options = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'data_type' => $this->data_type,
            'id' => $this->id,
            'name' => $this->name,
            'project_url' => $this->project_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'configuration' => $this->configuration,
            'issue_field_id' => $this->issue_field_id,
            'node_id' => $this->node_id,
            'options' => $this->options,
        ];
    }
}
