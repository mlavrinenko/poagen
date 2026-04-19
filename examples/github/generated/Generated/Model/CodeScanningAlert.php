<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAlertDismissedReason;
use Acme\GitHub\Generated\Enum\CodeScanningAlertState;
use JsonSerializable;

final readonly class CodeScanningAlert implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', \Acme\GitHub\Generated\Model\AlertCreatedAt::class],
        'dismissed_at' => ['dismissed_at', \Acme\GitHub\Generated\Model\AlertDismissedAt::class],
        'dismissed_by' => ['dismissed_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'dismissed_reason' => [
            'dismissed_reason',
            ['enum', \Acme\GitHub\Generated\Enum\CodeScanningAlertDismissedReason::class],
        ],
        'html_url' => ['html_url', \Acme\GitHub\Generated\Model\AlertHtmlUrl::class],
        'instances_url' => ['instances_url', \Acme\GitHub\Generated\Model\AlertInstancesUrl::class],
        'most_recent_instance' => ['most_recent_instance', \Acme\GitHub\Generated\Model\CodeScanningAlertInstance::class],
        'number' => ['number', \Acme\GitHub\Generated\Model\AlertNumber::class],
        'rule' => ['rule', \Acme\GitHub\Generated\Model\CodeScanningAlertRule::class],
        'state' => ['state', ['enum', \Acme\GitHub\Generated\Enum\CodeScanningAlertState::class]],
        'tool' => ['tool', \Acme\GitHub\Generated\Model\CodeScanningAnalysisTool::class],
        'url' => ['url', \Acme\GitHub\Generated\Model\AlertUrl::class],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'dismissal_approved_by' => ['dismissal_approved_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'dismissed_comment' => ['dismissed_comment', \Acme\GitHub\Generated\Model\CodeScanningAlertDismissedComment::class],
        'fixed_at' => ['fixed_at', \Acme\GitHub\Generated\Model\AlertFixedAt::class],
        'updated_at' => ['updated_at', \Acme\GitHub\Generated\Model\AlertUpdatedAt::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'dismissed_at' => $this->dismissed_at,
            'dismissed_by' => $this->dismissed_by,
            'dismissed_reason' => $this->dismissed_reason,
            'html_url' => $this->html_url,
            'instances_url' => $this->instances_url,
            'most_recent_instance' => $this->most_recent_instance,
            'number' => $this->number,
            'rule' => $this->rule,
            'state' => $this->state,
            'tool' => $this->tool,
            'url' => $this->url,
            'assignees' => $this->assignees,
            'dismissal_approved_by' => $this->dismissal_approved_by,
            'dismissed_comment' => $this->dismissed_comment,
            'fixed_at' => $this->fixed_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
