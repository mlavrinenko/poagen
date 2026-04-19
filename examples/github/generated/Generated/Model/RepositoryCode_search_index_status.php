<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryCode_search_index_status implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'lexical_commit_sha' => ['lexical_commit_sha', null],
        'lexical_search_ok' => ['lexical_search_ok', null],
    ];

    public function __construct(
        public ?string $lexical_commit_sha = null,
        public ?bool $lexical_search_ok = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'lexical_commit_sha' => $this->lexical_commit_sha,
            'lexical_search_ok' => $this->lexical_search_ok,
        ];
    }
}
