<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationCreateIssueField
{
    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public string $data_type,
        public string $name,
        public ?string $description = null,
        public ?array $options = null,
        public ?string $visibility = null,
    ) {
    }
}
