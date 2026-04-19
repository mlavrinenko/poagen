<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ConvertedNoteToIssueIssueEventProject_card implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'column_name' => ['column_name', null],
        'id' => ['id', null],
        'project_id' => ['project_id', null],
        'project_url' => ['project_url', null],
        'url' => ['url', null],
        'previous_column_name' => ['previous_column_name', null],
    ];

    public function __construct(
        public string $column_name,
        public int $id,
        public int $project_id,
        public string $project_url,
        public string $url,
        public ?string $previous_column_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'column_name' => $this->column_name,
            'id' => $this->id,
            'project_id' => $this->project_id,
            'project_url' => $this->project_url,
            'url' => $this->url,
            'previous_column_name' => $this->previous_column_name,
        ];
    }
}
