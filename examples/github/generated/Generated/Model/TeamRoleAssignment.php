<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TeamRoleAssignment
{
    public function __construct(
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $node_id,
        public NullableTeamSimple $parent,
        public string $permission,
        public string $repositories_url,
        public string $slug,
        public string $type,
        public string $url,
        public ?string $assignment = null,
        public ?int $enterprise_id = null,
        public ?string $notification_setting = null,
        public ?int $organization_id = null,
        public ?TeamRoleAssignmentPermissions $permissions = null,
        public ?string $privacy = null,
    ) {
    }
}
