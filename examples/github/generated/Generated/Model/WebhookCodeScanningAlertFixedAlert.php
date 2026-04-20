<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCodeScanningAlertFixedAlert
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?DateTimeImmutable $dismissed_at = null,
        public WebhookCodeScanningAlertFixedAlertDismissed_by $dismissed_by,
        public ?string $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertFixedAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertFixedAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?string $instances_url = null,
        public ?WebhookCodeScanningAlertFixedAlertMost_recent_instance $most_recent_instance = null,
    ) {
    }
}
