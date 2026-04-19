<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2DraftIssue implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'body' => ['body', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public float $id,
        public string $node_id,
        public string $title,
        public DateTimeImmutable $updated_at,
        public NullableSimpleUser $user,
        public ?string $body = null,
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
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'user' => $this->user,
            'body' => $this->body,
        ];
    }
}
