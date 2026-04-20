<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertClosedByUserAlert
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public DateTimeImmutable $dismissed_at,
        public WebhookCodeScanningAlertClosedByUserAlertDismissed_by $dismissed_by,
        public ?string $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertClosedByUserAlertRule $rule,
        public string $state,
        public WebhookCodeScanningAlertClosedByUserAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public ?WebhookCodeScanningAlertClosedByUserAlertDismissal_approved_by $dismissal_approved_by = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?WebhookCodeScanningAlertClosedByUserAlertMost_recent_instance $most_recent_instance = null,
    ) {
    }
}
