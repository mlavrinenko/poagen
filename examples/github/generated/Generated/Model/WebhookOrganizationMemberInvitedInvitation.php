<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookOrganizationMemberInvitedInvitation
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $email = null,
        public ?DateTimeImmutable $failed_at = null,
        public ?string $failed_reason = null,
        public float $id,
        public string $invitation_teams_url,
        public WebhookOrganizationMemberInvitedInvitationInviter $inviter,
        public ?string $login = null,
        public string $node_id,
        public string $role,
        public float $team_count,
        public ?string $invitation_source = null,
    ) {
    }
}
