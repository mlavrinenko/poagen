<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProtectedBranchPullRequestReviewBypass_pull_request_allowances implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'apps' => ['apps', ['list', \Acme\GitHub\Generated\Model\Integration::class]],
        'teams' => ['teams', ['list', \Acme\GitHub\Generated\Model\Team::class]],
        'users' => ['users', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\Integration> $apps
     * @param ?list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $users
     */
    public function __construct(
        public ?array $apps = null,
        public ?array $teams = null,
        public ?array $users = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'apps' => $this->apps,
            'teams' => $this->teams,
            'users' => $this->users,
        ];
    }
}
