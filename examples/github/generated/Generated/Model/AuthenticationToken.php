<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class AuthenticationToken
{
    /**
     * @param ?array<string, mixed> $permissions
     * @param ?list<\Acme\GitHub\Generated\Model\Repository> $repositories
     */
    public function __construct(
        public DateTimeImmutable $expires_at,
        public string $token,
        public ?array $permissions = null,
        public ?array $repositories = null,
        public ?string $repository_selection = null,
        public ?string $single_file = null,
    ) {
    }
}
