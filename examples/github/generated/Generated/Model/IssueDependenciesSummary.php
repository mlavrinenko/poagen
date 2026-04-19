<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class IssueDependenciesSummary implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'blocked_by' => ['blocked_by', null],
        'blocking' => ['blocking', null],
        'total_blocked_by' => ['total_blocked_by', null],
        'total_blocking' => ['total_blocking', null],
    ];

    public function __construct(
        public int $blocked_by,
        public int $blocking,
        public int $total_blocked_by,
        public int $total_blocking,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'blocked_by' => $this->blocked_by,
            'blocking' => $this->blocking,
            'total_blocked_by' => $this->total_blocked_by,
            'total_blocking' => $this->total_blocking,
        ];
    }
}
