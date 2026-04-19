<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class TimelineCommitCommentedEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', ['list', \Acme\GitHub\Generated\Model\CommitComment::class]],
        'commit_id' => ['commit_id', null],
        'event' => ['event', null],
        'node_id' => ['node_id', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\CommitComment> $comments
     */
    public function __construct(
        public ?array $comments = null,
        public ?string $commit_id = null,
        public ?string $event = null,
        public ?string $node_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comments' => $this->comments,
            'commit_id' => $this->commit_id,
            'event' => $this->event,
            'node_id' => $this->node_id,
        ];
    }
}
