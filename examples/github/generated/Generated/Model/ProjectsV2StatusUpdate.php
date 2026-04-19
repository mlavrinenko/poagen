<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2StatusUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'body' => ['body', null],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'project_node_id' => ['project_node_id', null],
        'start_date' => ['start_date', ['date', null]],
        'status' => ['status', null],
        'target_date' => ['target_date', ['date', null]],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public float $id,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public ?string $body = null,
        public ?SimpleUser $creator = null,
        public ?string $project_node_id = null,
        public ?DateTimeImmutable $start_date = null,
        public ?string $status = null,
        public ?DateTimeImmutable $target_date = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'node_id' => $this->node_id,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'body' => $this->body,
            'creator' => $this->creator,
            'project_node_id' => $this->project_node_id,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'status' => $this->status,
            'target_date' => $this->target_date?->format('Y-m-d'),
        ];
    }
}
