<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchPullRequestReviewBypass_pull_request_allowances
{
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
}
