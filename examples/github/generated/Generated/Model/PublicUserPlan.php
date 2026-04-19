<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PublicUserPlan implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'collaborators' => ['collaborators', null],
        'name' => ['name', null],
        'private_repos' => ['private_repos', null],
        'space' => ['space', null],
    ];

    public function __construct(
        public int $collaborators,
        public string $name,
        public int $private_repos,
        public int $space,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'collaborators' => $this->collaborators,
            'name' => $this->name,
            'private_repos' => $this->private_repos,
            'space' => $this->space,
        ];
    }
}
