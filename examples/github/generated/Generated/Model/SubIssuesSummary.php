<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SubIssuesSummary implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed' => ['completed', null],
        'percent_completed' => ['percent_completed', null],
        'total' => ['total', null],
    ];

    public function __construct(
        public int $completed,
        public int $percent_completed,
        public int $total,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed' => $this->completed,
            'percent_completed' => $this->percent_completed,
            'total' => $this->total,
        ];
    }
}
