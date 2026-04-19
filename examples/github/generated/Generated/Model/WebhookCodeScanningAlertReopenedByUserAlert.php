<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookCodeScanningAlertReopenedByUserAlert implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'dismissed_at' => ['dismissed_at', null],
        'dismissed_by' => ['dismissed_by', null],
        'dismissed_reason' => ['dismissed_reason', null],
        'html_url' => ['html_url', null],
        'number' => ['number', null],
        'rule' => ['rule', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertReopenedByUserAlertRule::class],
        'state' => ['state', null],
        'tool' => ['tool', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertReopenedByUserAlertTool::class],
        'url' => ['url', null],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'dismissed_comment' => ['dismissed_comment', \Acme\GitHub\Generated\Model\CodeScanningAlertDismissedComment::class],
        'fixed_at' => ['fixed_at', null],
        'most_recent_instance' => [
            'most_recent_instance',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instance::class,
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'dismissed_at' => $this->dismissed_at,
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
