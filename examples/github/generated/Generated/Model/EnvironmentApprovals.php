<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class EnvironmentApprovals
{
    /**
     * @param list<array<string, mixed>> $environments
     */
    public function __construct(
        public string $comment,
        public array $environments,
        public string $state,
        public SimpleUser $user,
    ) {
    }
}
