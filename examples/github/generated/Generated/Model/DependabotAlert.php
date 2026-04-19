<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependabotAlert implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', \Acme\GitHub\Generated\Model\AlertCreatedAt::class],
        'dependency' => ['dependency', \Acme\GitHub\Generated\Model\DependabotAlertDependency::class],
        'dismissed_at' => ['dismissed_at', \Acme\GitHub\Generated\Model\AlertDismissedAt::class],
        'dismissed_by' => ['dismissed_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'dismissed_comment' => ['dismissed_comment', null],
        'dismissed_reason' => ['dismissed_reason', null],
        'fixed_at' => ['fixed_at', \Acme\GitHub\Generated\Model\AlertFixedAt::class],
        'html_url' => ['html_url', \Acme\GitHub\Generated\Model\AlertHtmlUrl::class],
        'number' => ['number', \Acme\GitHub\Generated\Model\AlertNumber::class],
        'security_advisory' => ['security_advisory', \Acme\GitHub\Generated\Model\DependabotAlertSecurityAdvisory::class],
        'security_vulnerability' => [
            'security_vulnerability',
            \Acme\GitHub\Generated\Model\DependabotAlertSecurityVulnerability::class,
        ],
        'state' => ['state', null],
        'updated_at' => ['updated_at', \Acme\GitHub\Generated\Model\AlertUpdatedAt::class],
        'url' => ['url', \Acme\GitHub\Generated\Model\AlertUrl::class],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'auto_dismissed_at' => ['auto_dismissed_at', \Acme\GitHub\Generated\Model\AlertAutoDismissedAt::class],
        'dismissal_request' => [
            'dismissal_request',
            \Acme\GitHub\Generated\Model\DependabotAlertDismissalRequestSimple::class,
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'dependency' => $this->dependency,
            'dismissed_at' => $this->dismissed_at,
            'dismissed_by' => $this->dismissed_by,
            'dismissed_comment' => $this->dismissed_comment,
            'dismissed_reason' => $this->dismissed_reason,
            'fixed_at' => $this->fixed_at,
            'html_url' => $this->html_url,
            'number' => $this->number,
            'security_advisory' => $this->security_advisory,
            'security_vulnerability' => $this->security_vulnerability,
            'state' => $this->state,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'assignees' => $this->assignees,
            'auto_dismissed_at' => $this->auto_dismissed_at,
            'dismissal_request' => $this->dismissal_request,
        ];
    }
}
