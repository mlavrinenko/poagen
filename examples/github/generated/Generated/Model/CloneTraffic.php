<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CloneTraffic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'clones' => ['clones', ['list', \Acme\GitHub\Generated\Model\Traffic::class]],
        'count' => ['count', null],
        'uniques' => ['uniques', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\Traffic> $clones
     */
    public function __construct(
        public array $clones,
        public int $count,
        public int $uniques,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'clones' => $this->clones,
            'count' => $this->count,
            'uniques' => $this->uniques,
        ];
    }
}
