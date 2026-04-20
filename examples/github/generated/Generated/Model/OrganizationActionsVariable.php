<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class OrganizationActionsVariable
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $name,
        public DateTimeImmutable $updated_at,
        public string $value,
        public string $visibility,
        public ?string $selected_repositories_url = null,
    ) {
    }
}
