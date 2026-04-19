<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookProjectCardDeletedProject_card implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archived' => ['archived', null],
        'column_id' => ['column_id', null],
        'column_url' => ['column_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\WebhookProjectCardDeletedProject_cardCreator::class],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'note' => ['note', null],
        'project_url' => ['project_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'after_id' => ['after_id', null],
        'content_url' => ['content_url', null],
    ];

    public function __construct(
        public bool $archived,
        public ?int $column_id = null,
        public string $column_url,
        public DateTimeImmutable $created_at,
        public WebhookProjectCardDeletedProject_cardCreator $creator,
        public int $id,
        public string $node_id,
        public ?string $note = null,
        public string $project_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $after_id = null,
        public ?string $content_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archived' => $this->archived,
            'column_id' => $this->column_id,
            'column_url' => $this->column_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'note' => $this->note,
            'project_url' => $this->project_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'after_id' => $this->after_id,
            'content_url' => $this->content_url,
        ];
    }
}
