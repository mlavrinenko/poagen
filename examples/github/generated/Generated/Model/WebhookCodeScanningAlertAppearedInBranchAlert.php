<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookCodeScanningAlertAppearedInBranchAlert implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'dismissed_at' => ['dismissed_at', ['datetime', null]],
        'dismissed_by' => [
            'dismissed_by',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertAppearedInBranchAlertDismissed_by::class,
        ],
        'dismissed_reason' => ['dismissed_reason', null],
        'html_url' => ['html_url', null],
        'number' => ['number', null],
        'rule' => ['rule', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertAppearedInBranchAlertRule::class],
        'state' => ['state', null],
        'tool' => ['tool', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertAppearedInBranchAlertTool::class],
        'url' => ['url', null],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'dismissed_comment' => ['dismissed_comment', \Acme\GitHub\Generated\Model\CodeScanningAlertDismissedComment::class],
        'fixed_at' => ['fixed_at', null],
        'most_recent_instance' => [
            'most_recent_instance',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertAppearedInBranchAlertMost_recent_instance::class,
        ],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?mixed $fixed_at
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?DateTimeImmutable $dismissed_at = null,
        public WebhookCodeScanningAlertAppearedInBranchAlertDismissed_by $dismissed_by,
        public ?string $dismissed_reason = null,
        public string $html_url,
        public int $number,
        public WebhookCodeScanningAlertAppearedInBranchAlertRule $rule,
        public ?string $state = null,
        public WebhookCodeScanningAlertAppearedInBranchAlertTool $tool,
        public string $url,
        public ?array $assignees = null,
        public ?CodeScanningAlertDismissedComment $dismissed_comment = null,
        public $fixed_at = null,
        public ?WebhookCodeScanningAlertAppearedInBranchAlertMost_recent_instance $most_recent_instance = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'dismissed_at' => $this->dismissed_at?->format(\DateTimeInterface::RFC3339),
            'dismissed_by' => $this->dismissed_by,
            'dismissed_reason' => $this->dismissed_reason,
            'html_url' => $this->html_url,
            'number' => $this->number,
            'rule' => $this->rule,
            'state' => $this->state,
            'tool' => $this->tool,
            'url' => $this->url,
            'assignees' => $this->assignees,
            'dismissed_comment' => $this->dismissed_comment,
            'fixed_at' => $this->fixed_at,
            'most_recent_instance' => $this->most_recent_instance,
        ];
    }
}
