<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ContributorActivity implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'total' => ['total', null],
        'weeks' => ['weeks', ['list', null]],
    ];

    /**
     * @param list<array<string, mixed>> $weeks
     */
    public function __construct(
        public NullableSimpleUser $author,
        public int $total,
        public array $weeks,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'total' => $this->total,
            'weeks' => $this->weeks,
        ];
    }
}
