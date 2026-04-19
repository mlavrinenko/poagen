<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CommitActivity implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'days' => ['days', ['list', null]],
        'total' => ['total', null],
        'week' => ['week', null],
    ];

    /**
     * @param list<int> $days
     */
    public function __construct(
        public array $days,
        public int $total,
        public int $week,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'days' => $this->days,
            'total' => $this->total,
            'week' => $this->week,
        ];
    }
}
