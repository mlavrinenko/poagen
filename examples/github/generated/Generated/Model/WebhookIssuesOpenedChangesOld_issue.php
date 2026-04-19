<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookIssuesOpenedChangesOld_issue implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'number' => ['number', null],
        'active_lock_reason' => ['active_lock_reason', null],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issueAssignee::class],
        'assignees' => ['assignees', ['list', null]],
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'closed_at' => ['closed_at', ['datetime', null]],
        'comments' => ['comments', null],
        'comments_url' => ['comments_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'draft' => ['draft', null],
        'events_url' => ['events_url', null],
        'html_url' => ['html_url', null],
        'issue_dependencies_summary' => [
            'issue_dependencies_summary',
            \Acme\GitHub\Generated\Model\IssueDependenciesSummary::class,
        ],
        'issue_field_values' => ['issue_field_values', ['list', \Acme\GitHub\Generated\Model\IssueFieldValue::class]],
        'labels' => ['labels', ['list', null]],
        'labels_url' => ['labels_url', null],
        'locked' => ['locked', null],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issueMilestone::class],
        'node_id' => ['node_id', null],
        'performed_via_github_app' => [
            'performed_via_github_app',
            \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issuePerformed_via_github_app::class,
        ],
        'pinned_comment' => ['pinned_comment', \Acme\GitHub\Generated\Model\NullableIssueComment::class],
        'pull_request' => [
            'pull_request',
            \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issuePull_request::class,
        ],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issueReactions::class],
        'repository_url' => ['repository_url', null],
        'state' => ['state', null],
        'state_reason' => ['state_reason', null],
        'sub_issues_summary' => ['sub_issues_summary', \Acme\GitHub\Generated\Model\SubIssuesSummary::class],
        'timeline_url' => ['timeline_url', null],
        'title' => ['title', null],
        'type' => ['type', \Acme\GitHub\Generated\Model\IssueType::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issueUser::class],
    ];

    /**
     * @param ?list<array<string, mixed>> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\IssueFieldValue> $issue_field_values
     * @param ?list<array<string, mixed>> $labels
     */
    public function __construct(
        public int $id,
        public int $number,
        public ?string $active_lock_reason = null,
        public ?WebhookIssuesOpenedChangesOld_issueAssignee $assignee = null,
        public ?array $assignees = null,
        public ?string $author_association = null,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public ?int $comments = null,
        public ?string $comments_url = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $draft = null,
        public ?string $events_url = null,
        public ?string $html_url = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?array $labels = null,
        public ?string $labels_url = null,
        public ?bool $locked = null,
        public ?WebhookIssuesOpenedChangesOld_issueMilestone $milestone = null,
        public ?string $node_id = null,
        public ?WebhookIssuesOpenedChangesOld_issuePerformed_via_github_app $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?WebhookIssuesOpenedChangesOld_issuePull_request $pull_request = null,
        public ?WebhookIssuesOpenedChangesOld_issueReactions $reactions = null,
        public ?string $repository_url = null,
        public ?string $state = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?string $timeline_url = null,
        public ?string $title = null,
        public ?IssueType $type = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?WebhookIssuesOpenedChangesOld_issueUser $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'active_lock_reason' => $this->active_lock_reason,
            'assignee' => $this->assignee,
            'assignees' => $this->assignees,
            'author_association' => $this->author_association,
            'body' => $this->body,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'comments' => $this->comments,
            'comments_url' => $this->comments_url,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'draft' => $this->draft,
            'events_url' => $this->events_url,
            'html_url' => $this->html_url,
            'issue_dependencies_summary' => $this->issue_dependencies_summary,
            'issue_field_values' => $this->issue_field_values,
            'labels' => $this->labels,
            'labels_url' => $this->labels_url,
            'locked' => $this->locked,
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'performed_via_github_app' => $this->performed_via_github_app,
            'pinned_comment' => $this->pinned_comment,
            'pull_request' => $this->pull_request,
            'reactions' => $this->reactions,
            'repository_url' => $this->repository_url,
            'state' => $this->state,
            'state_reason' => $this->state_reason,
            'sub_issues_summary' => $this->sub_issues_summary,
            'timeline_url' => $this->timeline_url,
            'title' => $this->title,
            'type' => $this->type,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
        ];
    }
}
