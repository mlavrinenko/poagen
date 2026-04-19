<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookIssuesReopenedIssue implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active_lock_reason' => ['active_lock_reason', null],
        'assignees' => ['assignees', ['list', null]],
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'closed_at' => ['closed_at', ['datetime', null]],
        'comments' => ['comments', null],
        'comments_url' => ['comments_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'events_url' => ['events_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'labels_url' => ['labels_url', null],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssueMilestone::class],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssueReactions::class],
        'repository_url' => ['repository_url', null],
        'state' => ['state', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssueUser::class],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssueAssignee::class],
        'draft' => ['draft', null],
        'issue_dependencies_summary' => [
            'issue_dependencies_summary',
            \Acme\GitHub\Generated\Model\IssueDependenciesSummary::class,
        ],
        'issue_field_values' => ['issue_field_values', ['list', \Acme\GitHub\Generated\Model\IssueFieldValue::class]],
        'labels' => ['labels', ['list', null]],
        'locked' => ['locked', null],
        'performed_via_github_app' => [
            'performed_via_github_app',
            \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssuePerformed_via_github_app::class,
        ],
        'pinned_comment' => ['pinned_comment', \Acme\GitHub\Generated\Model\NullableIssueComment::class],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\WebhookIssuesReopenedIssuePull_request::class],
        'state_reason' => ['state_reason', null],
        'sub_issues_summary' => ['sub_issues_summary', \Acme\GitHub\Generated\Model\SubIssuesSummary::class],
        'timeline_url' => ['timeline_url', null],
        'type' => ['type', \Acme\GitHub\Generated\Model\IssueType::class],
    ];

    /**
     * @param list<array<string, mixed>> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\IssueFieldValue> $issue_field_values
     * @param ?list<array<string, mixed>> $labels
     */
    public function __construct(
        public ?string $active_lock_reason = null,
        public array $assignees,
        public string $author_association,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public int $comments,
        public string $comments_url,
        public DateTimeImmutable $created_at,
        public string $events_url,
        public string $html_url,
        public int $id,
        public string $labels_url,
        public WebhookIssuesReopenedIssueMilestone $milestone,
        public string $node_id,
        public int $number,
        public WebhookIssuesReopenedIssueReactions $reactions,
        public string $repository_url,
        public string $state,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhookIssuesReopenedIssueUser $user,
        public ?WebhookIssuesReopenedIssueAssignee $assignee = null,
        public ?bool $draft = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?array $labels = null,
        public ?bool $locked = null,
        public ?WebhookIssuesReopenedIssuePerformed_via_github_app $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?WebhookIssuesReopenedIssuePull_request $pull_request = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?string $timeline_url = null,
        public ?IssueType $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active_lock_reason' => $this->active_lock_reason,
            'assignees' => $this->assignees,
            'author_association' => $this->author_association,
            'body' => $this->body,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'comments' => $this->comments,
            'comments_url' => $this->comments_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'events_url' => $this->events_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'labels_url' => $this->labels_url,
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'reactions' => $this->reactions,
            'repository_url' => $this->repository_url,
            'state' => $this->state,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'assignee' => $this->assignee,
            'draft' => $this->draft,
            'issue_dependencies_summary' => $this->issue_dependencies_summary,
            'issue_field_values' => $this->issue_field_values,
            'labels' => $this->labels,
            'locked' => $this->locked,
            'performed_via_github_app' => $this->performed_via_github_app,
            'pinned_comment' => $this->pinned_comment,
            'pull_request' => $this->pull_request,
            'state_reason' => $this->state_reason,
            'sub_issues_summary' => $this->sub_issues_summary,
            'timeline_url' => $this->timeline_url,
            'type' => $this->type,
        ];
    }
}
