<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrgMembership
{
    /**
     * @param ?list<string> $enterprise_teams_providing_indirect_membership
     */
    public function __construct(
        public OrganizationSimple $organization,
        public string $organization_url,
        public string $role,
        public string $state,
        public string $url,
        public NullableSimpleUser $user,
        public ?bool $direct_membership = null,
        public ?array $enterprise_teams_providing_indirect_membership = null,
        public ?OrgMembershipPermissions $permissions = null,
    ) {
    }
}
