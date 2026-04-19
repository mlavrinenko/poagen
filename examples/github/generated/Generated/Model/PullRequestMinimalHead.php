<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestMinimalHead implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ref' => ['ref', null],
        'repo' => ['repo', \Acme\GitHub\Generated\Model\PullRequestMinimalHeadRepo::class],
        'sha' => ['sha', null],
    ];

    public function __construct(
        public string $ref,
        public PullRequestMinimalHeadRepo $repo,
        public string $sha,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ref' => $this->ref,
            'repo' => $this->repo,
            'sha' => $this->sha,
        ];
    }
}
