<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TeamSimple
{
    public function __construct(
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $node_id,
        public string $permission,
        public string $repositories_url,
        public string $slug,
        public string $type,
        public string $url,
        public ?int $enterprise_id = null,
        public ?string $ldap_dn = null,
        public ?string $notification_setting = null,
        public ?int $organization_id = null,
        public ?string $privacy = null,
    ) {
    }
}
