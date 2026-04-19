<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookCodeScanningAlertCreatedAlert implements JsonSerializable
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
        'rule' => ['rule', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertCreatedAlertRule::class],
        'state' => ['state', null],
        'tool' => ['tool', \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertCreatedAlertTool::class],
        'url' => ['url', null],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'dismissal_approved_by' => ['dismissal_approved_by', null],
        'dismissed_comment' => ['dismissed_comment', \Acme\GitHub\Generated\Model\CodeScanningAlertDismissedComment::class],
        'fixed_at' => ['fixed_at', null],
        'instances_url' => ['instances_url', null],
        'most_recent_instance' => [
            'most_recent_instance',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertCreatedAlertMost_recent_instance::class,
        ],
        'updated_at' => ['updated_at', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
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
            'dismissal_approved_by' => $this->dismissal_approved_by,
            'dismissed_comment' => $this->dismissed_comment,
            'fixed_at' => $this->fixed_at,
            'instances_url' => $this->instances_url,
            'most_recent_instance' => $this->most_recent_instance,
            'updated_at' => $this->updated_at,
        ];
    }
}
