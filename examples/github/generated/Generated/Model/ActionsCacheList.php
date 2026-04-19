<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsCacheList implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actions_caches' => ['actions_caches', ['list', null]],
        'total_count' => ['total_count', null],
    ];

    /**
     * @param list<array<string, mixed>> $actions_caches
     */
    public function __construct(
        public array $actions_caches,
        public int $total_count,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actions_caches' => $this->actions_caches,
            'total_count' => $this->total_count,
        ];
    }
}
