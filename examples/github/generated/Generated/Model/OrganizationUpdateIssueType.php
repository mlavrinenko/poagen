<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationUpdateIssueType
{
    public function __construct(
        public bool $is_enabled,
        public string $name,
        public ?string $color = null,
        public ?string $description = null,
    ) {
    }
}
