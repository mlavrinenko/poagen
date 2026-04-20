<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TeamOrganizationPlan
{
    public function __construct(
        public string $name,
        public int $private_repos,
        public int $space,
        public ?int $filled_seats = null,
        public ?int $seats = null,
    ) {
    }
}
