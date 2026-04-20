<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertCreatedAlert
{
    /**
     * @param ?mixed $dismissed_at
     * @param ?mixed $dismissed_by
     * @param ?mixed $dismissed_reason
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $dismissal_approved_by
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public $dismissed_at = null,
        public $dismissed_by = null,
        public $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertCreatedAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertCreatedAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public $dismissal_approved_by = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?string $instances_url = null,
        public ?WebhookCodeScanningAlertCreatedAlertMost_recent_instance $most_recent_instance = null,
        public ?string $updated_at = null,
    ) {
    }
}
