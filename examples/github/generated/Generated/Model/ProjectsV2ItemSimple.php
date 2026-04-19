<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\ProjectsV2ItemContentType;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2ItemSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archived_at' => ['archived_at', ['datetime', null]],
        'content_type' => ['content_type', ['enum', \Acme\GitHub\Generated\Enum\ProjectsV2ItemContentType::class]],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'content' => [
            'content',
            [
                'union',
                [
                    \Acme\GitHub\Generated\Model\Issue::class,
                    \Acme\GitHub\Generated\Model\PullRequestSimple::class,
                    \Acme\GitHub\Generated\Model\ProjectsV2DraftIssue::class,
                ],
                null,
            ],
        ],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'item_url' => ['item_url', null],
        'node_id' => ['node_id', null],
        'project_url' => ['project_url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $archived_at = null,
        public ProjectsV2ItemContentType $content_type,
        public DateTimeImmutable $created_at,
        public float $id,
        public DateTimeImmutable $updated_at,
        public Issue|PullRequestSimple|ProjectsV2DraftIssue|null $content = null,
        public ?SimpleUser $creator = null,
        public ?string $item_url = null,
        public ?string $node_id = null,
        public ?string $project_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archived_at' => $this->archived_at?->format(\DateTimeInterface::RFC3339),
            'content_type' => $this->content_type,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'content' => $this->content,
            'creator' => $this->creator,
            'item_url' => $this->item_url,
            'node_id' => $this->node_id,
            'project_url' => $this->project_url,
        ];
    }
}
