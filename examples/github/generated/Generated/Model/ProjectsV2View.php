<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2View implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', null],
        'group_by' => ['group_by', ['list', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'layout' => ['layout', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'project_url' => ['project_url', null],
        'sort_by' => ['sort_by', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vertical_group_by' => ['vertical_group_by', ['list', null]],
        'visible_fields' => ['visible_fields', ['list', null]],
        'filter' => ['filter', null],
    ];

    /**
     * @param mixed $creator
     * @param list<int> $group_by
     * @param list<list<mixed>> $sort_by
     * @param list<int> $vertical_group_by
     * @param list<int> $visible_fields
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public $creator,
        public array $group_by,
        public string $html_url,
        public int $id,
        public string $layout,
        public string $name,
        public string $node_id,
        public int $number,
        public string $project_url,
        public array $sort_by,
        public DateTimeImmutable $updated_at,
        public array $vertical_group_by,
        public array $visible_fields,
        public ?string $filter = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'group_by' => $this->group_by,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'layout' => $this->layout,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'project_url' => $this->project_url,
            'sort_by' => $this->sort_by,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'vertical_group_by' => $this->vertical_group_by,
            'visible_fields' => $this->visible_fields,
            'filter' => $this->filter,
        ];
    }
}
