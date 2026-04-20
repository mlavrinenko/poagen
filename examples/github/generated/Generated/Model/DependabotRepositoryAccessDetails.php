<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependabotRepositoryAccessDetails
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\NullableSimpleRepository> $accessible_repositories
     */
    public function __construct(
        public ?array $accessible_repositories = null,
        public ?string $default_level = null,
    ) {
    }
}
