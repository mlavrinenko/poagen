<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class OrganizationRole
{
    /**
     * @param list<string> $permissions
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public NullableSimpleUser $organization,
        public array $permissions,
        public DateTimeImmutable $updated_at,
        public ?string $base_role = null,
        public ?string $description = null,
        public ?string $source = null,
    ) {
    }
}
