<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationUpdateIssueField
{
    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public ?string $description = null,
        public ?string $name = null,
        public ?array $options = null,
        public ?string $visibility = null,
    ) {
    }
}
