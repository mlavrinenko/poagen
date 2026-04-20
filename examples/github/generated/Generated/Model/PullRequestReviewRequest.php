<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewRequest
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Team> $teams
     * @param list<\Acme\GitHub\Generated\Model\SimpleUser> $users
     */
    public function __construct(
        public array $teams,
        public array $users,
    ) {
    }
}
