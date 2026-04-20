<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAlertDismissedReason;
use Acme\GitHub\Generated\Enum\CodeScanningAlertState;

final readonly class CodeScanningAlert
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     */
    public function __construct(
        public AlertCreatedAt $created_at,
        public AlertDismissedAt $dismissed_at,
        public NullableSimpleUser $dismissed_by,
        public CodeScanningAlertDismissedReason $dismissed_reason,
        public AlertHtmlUrl $html_url,
        public AlertInstancesUrl $instances_url,
        public CodeScanningAlertInstance $most_recent_instance,
        public AlertNumber $number,
        public CodeScanningAlertRule $rule,
        public CodeScanningAlertState $state,
        public CodeScanningAnalysisTool $tool,
        public AlertUrl $url,
        public ?array $assignees = null,
        public ?NullableSimpleUser $dismissal_approved_by = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public ?AlertFixedAt $fixed_at = null,
        public ?AlertUpdatedAt $updated_at = null,
    ) {
    }
}
