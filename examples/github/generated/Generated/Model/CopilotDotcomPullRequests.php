<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotDotcomPullRequests
{
    /**
     * @param ?list<array<string, mixed>> $repositories
     */
    public function __construct(
        public ?array $repositories = null,
        public ?int $total_engaged_users = null,
    ) {
    }
}
