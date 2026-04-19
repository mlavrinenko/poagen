<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BranchRestrictionPolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'apps' => ['apps', ['list', null]],
        'apps_url' => ['apps_url', null],
        'teams' => ['teams', ['list', \Acme\GitHub\Generated\Model\Team::class]],
        'teams_url' => ['teams_url', null],
        'url' => ['url', null],
        'users' => ['users', ['list', null]],
        'users_url' => ['users_url', null],
    ];

    /**
     * @param list<array<string, mixed>> $apps
     * @param list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param list<array<string, mixed>> $users
     */
    public function __construct(
        public array $apps,
        public string $apps_url,
        public array $teams,
        public string $teams_url,
        public string $url,
        public array $users,
        public string $users_url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'apps' => $this->apps,
            'apps_url' => $this->apps_url,
            'teams' => $this->teams,
            'teams_url' => $this->teams_url,
            'url' => $this->url,
            'users' => $this->users,
            'users_url' => $this->users_url,
        ];
    }
}
