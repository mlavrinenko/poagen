<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertReopenedByUserAlert
{
    /**
     * @param ?mixed $dismissed_at
     * @param ?mixed $dismissed_by
     * @param ?mixed $dismissed_reason
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public $dismissed_at = null,
        public $dismissed_by = null,
        public $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertReopenedByUserAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertReopenedByUserAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instance $most_recent_instance = null,
    ) {
    }
}
