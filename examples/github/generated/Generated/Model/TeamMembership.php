<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TeamMembership
{
    public function __construct(
        public string $role,
        public string $state,
        public string $url,
    ) {
    }
}
