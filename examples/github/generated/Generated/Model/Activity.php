<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Activity implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'activity_type' => ['activity_type', null],
        'actor' => ['actor', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'after' => ['after', null],
        'before' => ['before', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'ref' => ['ref', null],
        'timestamp' => ['timestamp', ['datetime', null]],
    ];

    public function __construct(
        public string $activity_type,
        public NullableSimpleUser $actor,
        public string $after,
        public string $before,
        public int $id,
        public string $node_id,
        public string $ref,
        public DateTimeImmutable $timestamp,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'activity_type' => $this->activity_type,
            'actor' => $this->actor,
            'after' => $this->after,
            'before' => $this->before,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'ref' => $this->ref,
            'timestamp' => $this->timestamp->format(\DateTimeInterface::RFC3339),
        ];
    }
}
