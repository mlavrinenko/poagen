<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependabotAlert
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     */
    public function __construct(
        public AlertCreatedAt $created_at,
        public DependabotAlertDependency $dependency,
        public AlertDismissedAt $dismissed_at,
        public NullableSimpleUser $dismissed_by,
        public ?string $dismissed_comment = null,
        public ?string $dismissed_reason = null,
        public AlertFixedAt $fixed_at,
        public AlertHtmlUrl $html_url,
        public AlertNumber $number,
        public DependabotAlertSecurityAdvisory $security_advisory,
        public DependabotAlertSecurityVulnerability $security_vulnerability,
        public string $state,
        public AlertUpdatedAt $updated_at,
        public AlertUrl $url,
        public ?array $assignees = null,
        public ?AlertAutoDismissedAt $auto_dismissed_at = null,
        public ?DependabotAlertDismissalRequestSimple $dismissal_request = null,
    ) {
    }
}
