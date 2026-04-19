<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GitTree implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'sha' => ['sha', null],
        'tree' => ['tree', ['list', null]],
        'truncated' => ['truncated', null],
        'url' => ['url', null],
    ];

    /**
     * @param list<array<string, mixed>> $tree
     */
    public function __construct(
        public string $sha,
        public array $tree,
        public bool $truncated,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'sha' => $this->sha,
            'tree' => $this->tree,
            'truncated' => $this->truncated,
            'url' => $this->url,
        ];
    }
}
