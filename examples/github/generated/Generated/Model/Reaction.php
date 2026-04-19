<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Reaction implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content' => ['content', null],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

    public function __construct(
        public string $content,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $node_id,
        public NullableSimpleUser $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content' => $this->content,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'node_id' => $this->node_id,
            'user' => $this->user,
        ];
    }
}
