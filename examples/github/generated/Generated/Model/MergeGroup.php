<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MergeGroup implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'base_ref' => ['base_ref', null],
        'base_sha' => ['base_sha', null],
        'head_commit' => ['head_commit', \Acme\GitHub\Generated\Model\SimpleCommit::class],
        'head_ref' => ['head_ref', null],
        'head_sha' => ['head_sha', null],
    ];

    public function __construct(
        public string $base_ref,
        public string $base_sha,
        public SimpleCommit $head_commit,
        public string $head_ref,
        public string $head_sha,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'base_ref' => $this->base_ref,
            'base_sha' => $this->base_sha,
            'head_commit' => $this->head_commit,
            'head_ref' => $this->head_ref,
            'head_sha' => $this->head_sha,
        ];
    }
}
