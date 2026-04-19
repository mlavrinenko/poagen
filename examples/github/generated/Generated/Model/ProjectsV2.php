<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2 implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'closed_at' => ['closed_at', ['datetime', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'deleted_at' => ['deleted_at', ['datetime', null]],
        'deleted_by' => ['deleted_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'description' => ['description', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'public' => ['public', null],
        'short_description' => ['short_description', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'is_template' => ['is_template', null],
        'latest_status_update' => [
            'latest_status_update',
            \Acme\GitHub\Generated\Model\NullableProjectsV2StatusUpdate::class,
        ],
        'state' => ['state', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $closed_at = null,
        public DateTimeImmutable $created_at,
        public SimpleUser $creator,
        public ?DateTimeImmutable $deleted_at = null,
        public NullableSimpleUser $deleted_by,
        public ?string $description = null,
        public float $id,
        public string $node_id,
        public int $number,
        public SimpleUser $owner,
        public bool $public,
        public ?string $short_description = null,
        public string $title,
        public DateTimeImmutable $updated_at,
        public ?bool $is_template = null,
        public ?NullableProjectsV2StatusUpdate $latest_status_update = null,
        public ?string $state = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
            'deleted_by' => $this->deleted_by,
            'description' => $this->description,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'owner' => $this->owner,
            'public' => $this->public,
            'short_description' => $this->short_description,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'is_template' => $this->is_template,
            'latest_status_update' => $this->latest_status_update,
            'state' => $this->state,
        ];
    }
}
