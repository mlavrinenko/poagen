<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class CopilotSeatDetails
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?NullableSimpleUser $assignee = null,
        public Team|EnterpriseTeam|null $assigning_team = null,
        public ?DateTimeImmutable $last_activity_at = null,
        public ?string $last_activity_editor = null,
        public ?DateTimeImmutable $last_authenticated_at = null,
        public ?NullableOrganizationSimple $organization = null,
        #[Format('date')]
        public ?DateTimeImmutable $pending_cancellation_date = null,
        public ?string $plan_type = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
