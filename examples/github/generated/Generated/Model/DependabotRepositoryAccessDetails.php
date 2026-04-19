<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependabotRepositoryAccessDetails implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'accessible_repositories' => [
            'accessible_repositories',
            ['list', \Acme\GitHub\Generated\Model\NullableSimpleRepository::class],
        ],
        'default_level' => ['default_level', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\NullableSimpleRepository> $accessible_repositories
     */
    public function __construct(
        public ?array $accessible_repositories = null,
        public ?string $default_level = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'accessible_repositories' => $this->accessible_repositories,
            'default_level' => $this->default_level,
        ];
    }
}
