<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodespaceWithFullRepositoryRuntime_constraints
{
    /**
     * @param ?list<string> $allowed_port_privacy_settings
     */
    public function __construct(
        public ?array $allowed_port_privacy_settings = null,
    ) {
    }
}
