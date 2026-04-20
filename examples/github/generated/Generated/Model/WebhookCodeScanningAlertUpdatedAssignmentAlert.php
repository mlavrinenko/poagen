<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertUpdatedAssignmentAlert
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?DateTimeImmutable $dismissed_at = null,
        public WebhookCodeScanningAlertUpdatedAssignmentAlertDismissed_by $dismissed_by,
        public ?string $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertUpdatedAssignmentAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertUpdatedAssignmentAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?WebhookCodeScanningAlertUpdatedAssignmentAlertMost_recent_instance $most_recent_instance = null,
    ) {
    }
}
