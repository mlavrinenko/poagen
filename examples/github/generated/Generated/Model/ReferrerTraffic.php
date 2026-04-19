<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ReferrerTraffic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'count' => ['count', null],
        'referrer' => ['referrer', null],
        'uniques' => ['uniques', null],
    ];

    public function __construct(
        public int $count,
        public string $referrer,
        public int $uniques,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count,
            'referrer' => $this->referrer,
            'uniques' => $this->uniques,
        ];
    }
}
