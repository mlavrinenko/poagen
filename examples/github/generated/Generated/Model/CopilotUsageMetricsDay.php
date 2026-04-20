<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class CopilotUsageMetricsDay
{
    public function __construct(
        #[Format('date')]
        public DateTimeImmutable $date,
        public ?CopilotDotcomChat $copilot_dotcom_chat = null,
        public ?CopilotDotcomPullRequests $copilot_dotcom_pull_requests = null,
        public ?CopilotIdeChat $copilot_ide_chat = null,
        public ?CopilotIdeCodeCompletions $copilot_ide_code_completions = null,
        public ?int $total_active_users = null,
        public ?int $total_engaged_users = null,
    ) {
    }
}
