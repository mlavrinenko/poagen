<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class TeamOrganizationPlan implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'private_repos' => ['private_repos', null],
        'space' => ['space', null],
        'filled_seats' => ['filled_seats', null],
        'seats' => ['seats', null],
    ];

    public function __construct(
        public string $name,
        public int $private_repos,
        public int $space,
        public ?int $filled_seats = null,
        public ?int $seats = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'private_repos' => $this->private_repos,
            'space' => $this->space,
            'filled_seats' => $this->filled_seats,
            'seats' => $this->seats,
        ];
    }
}
