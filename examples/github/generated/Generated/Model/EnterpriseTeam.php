<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class EnterpriseTeam
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $group_id = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $slug,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $description = null,
        public ?string $group_name = null,
        public ?string $organization_selection_type = null,
        public ?string $sync_to_organizations = null,
    ) {
    }
}
