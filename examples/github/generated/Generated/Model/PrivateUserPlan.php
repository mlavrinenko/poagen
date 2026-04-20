<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PrivateUserPlan
{
    public function __construct(
        public int $collaborators,
        public string $name,
        public int $private_repos,
        public int $space,
    ) {
    }
}
