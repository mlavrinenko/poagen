<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\ActionsDefaultWorkflowPermissions;
use JsonSerializable;

final readonly class ActionsSetDefaultWorkflowPermissions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'can_approve_pull_request_reviews' => [
            'can_approve_pull_request_reviews',
            \Acme\GitHub\Generated\Model\ActionsCanApprovePullRequestReviews::class,
        ],
        'default_workflow_permissions' => [
            'default_workflow_permissions',
            ['enum', \Acme\GitHub\Generated\Enum\ActionsDefaultWorkflowPermissions::class],
        ],
    ];

    public function __construct(
        public ?ActionsCanApprovePullRequestReviews $can_approve_pull_request_reviews = null,
        public ?ActionsDefaultWorkflowPermissions $default_workflow_permissions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'can_approve_pull_request_reviews' => $this->can_approve_pull_request_reviews,
            'default_workflow_permissions' => $this->default_workflow_permissions,
        ];
    }
}
