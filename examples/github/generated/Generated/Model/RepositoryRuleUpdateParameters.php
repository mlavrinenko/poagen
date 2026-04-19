<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleUpdateParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['update_allows_fetch_and_merge' => ['update_allows_fetch_and_merge', null]];

    public function __construct(
        public bool $update_allows_fetch_and_merge,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'update_allows_fetch_and_merge' => $this->update_allows_fetch_and_merge,
        ];
    }
}
