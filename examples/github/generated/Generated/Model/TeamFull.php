<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class TeamFull
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public int $members_count,
        public string $members_url,
        public string $name,
        public string $node_id,
        public TeamOrganization $organization,
        public string $permission,
        public int $repos_count,
        public string $repositories_url,
        public string $slug,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $enterprise_id = null,
        public ?LdapDn $ldap_dn = null,
        public ?string $notification_setting = null,
        public ?int $organization_id = null,
        public ?NullableTeamSimple $parent = null,
        public ?string $privacy = null,
    ) {
    }
}
