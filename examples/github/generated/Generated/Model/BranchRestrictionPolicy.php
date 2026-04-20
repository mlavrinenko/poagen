<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class BranchRestrictionPolicy
{
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
}
