<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertReopenedAlert
{
    /**
     * @param ?array<string, mixed> $dismissed_by
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $dismissal_approved_by
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $dismissed_at = null,
        public ?array $dismissed_by = null,
        public ?string $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertReopenedAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertReopenedAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public $dismissal_approved_by = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?string $instances_url = null,
        public ?WebhookCodeScanningAlertReopenedAlertMost_recent_instance $most_recent_instance = null,
        public ?string $updated_at = null,
    ) {
    }
}
