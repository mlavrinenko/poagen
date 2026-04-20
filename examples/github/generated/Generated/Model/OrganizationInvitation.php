<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationInvitation
{
    public function __construct(
        public string $created_at,
        public ?string $email = null,
        public int $id,
        public string $invitation_teams_url,
        public SimpleUser $inviter,
        public ?string $login = null,
        public string $node_id,
        public string $role,
        public int $team_count,
        public ?string $failed_at = null,
        public ?string $failed_reason = null,
        public ?string $invitation_source = null,
    ) {
    }
}
