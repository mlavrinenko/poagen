<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchRequired_pull_request_reviewsBypass_pull_request_allowances
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param list<\Acme\GitHub\Generated\Model\SimpleUser> $users
     * @param ?list<\Acme\GitHub\Generated\Model\Integration> $apps
     */
    public function __construct(
        public array $teams,
        public array $users,
        public ?array $apps = null,
    ) {
    }
}
