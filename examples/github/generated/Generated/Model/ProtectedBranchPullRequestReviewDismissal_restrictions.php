<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchPullRequestReviewDismissal_restrictions
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\Integration> $apps
     * @param ?list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $users
     */
    public function __construct(
        public ?array $apps = null,
        public ?array $teams = null,
        public ?string $teams_url = null,
        public ?string $url = null,
        public ?array $users = null,
        public ?string $users_url = null,
    ) {
    }
}
