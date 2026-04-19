<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Traffic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'count' => ['count', null],
        'timestamp' => ['timestamp', ['datetime', null]],
        'uniques' => ['uniques', null],
    ];

    public function __construct(
        public int $count,
        public DateTimeImmutable $timestamp,
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
            'timestamp' => $this->timestamp->format(\DateTimeInterface::RFC3339),
            'uniques' => $this->uniques,
        ];
    }
}
