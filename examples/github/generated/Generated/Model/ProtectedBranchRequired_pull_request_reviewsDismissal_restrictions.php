<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchRequired_pull_request_reviewsDismissal_restrictions
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param list<\Acme\GitHub\Generated\Model\SimpleUser> $users
     * @param ?list<\Acme\GitHub\Generated\Model\Integration> $apps
     */
    public function __construct(
        public array $teams,
        public string $teams_url,
        public string $url,
        public array $users,
        public string $users_url,
        public ?array $apps = null,
    ) {
    }
}
