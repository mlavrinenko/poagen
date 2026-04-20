<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotOrganizationDetails
{
    public function __construct(
        public string $public_code_suggestions,
        public CopilotOrganizationSeatBreakdown $seat_breakdown,
        public string $seat_management_setting,
        public ?string $cli = null,
        public ?string $ide_chat = null,
        public ?string $plan_type = null,
        public ?string $platform_chat = null,
    ) {
    }
}
