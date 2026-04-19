<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ContentTraffic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'count' => ['count', null],
        'path' => ['path', null],
        'title' => ['title', null],
        'uniques' => ['uniques', null],
    ];

    public function __construct(
        public int $count,
        public string $path,
        public string $title,
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
            'path' => $this->path,
            'title' => $this->title,
            'uniques' => $this->uniques,
        ];
    }
}
