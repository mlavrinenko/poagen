<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class StarredRepository implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repo' => ['repo', \Acme\GitHub\Generated\Model\Repository::class],
        'starred_at' => ['starred_at', ['datetime', null]],
    ];

    public function __construct(
        public Repository $repo,
        public DateTimeImmutable $starred_at,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repo' => $this->repo,
            'starred_at' => $this->starred_at->format(\DateTimeInterface::RFC3339),
        ];
    }
}
