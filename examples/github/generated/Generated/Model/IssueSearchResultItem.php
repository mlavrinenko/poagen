<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;
use JsonSerializable;

final readonly class IssueSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'author_association' => ['author_association', ['enum', \Acme\GitHub\Generated\Enum\AuthorAssociation::class]],
        'closed_at' => ['closed_at', ['datetime', null]],
        'comments' => ['comments', null],
        'comments_url' => ['comments_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'events_url' => ['events_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'labels' => ['labels', ['list', null]],
        'labels_url' => ['labels_url', null],
        'locked' => ['locked', null],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\NullableMilestone::class],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'repository_url' => ['repository_url', null],
        'score' => ['score', null],
        'state' => ['state', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'active_lock_reason' => ['active_lock_reason', null],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'body' => ['body', null],
        'body_html' => ['body_html', null],
        'body_text' => ['body_text', null],
        'draft' => ['draft', null],
        'issue_dependencies_summary' => [
            'issue_dependencies_summary',
            \Acme\GitHub\Generated\Model\IssueDependenciesSummary::class,
        ],
        'issue_field_values' => ['issue_field_values', ['list', \Acme\GitHub\Generated\Model\IssueFieldValue::class]],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'pinned_comment' => ['pinned_comment', \Acme\GitHub\Generated\Model\NullableIssueComment::class],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\IssueSearchResultItemPull_request::class],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\ReactionRollup::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\Repository::class],
        'state_reason' => ['state_reason', null],
        'sub_issues_summary' => ['sub_issues_summary', \Acme\GitHub\Generated\Model\SubIssuesSummary::class],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
        'timeline_url' => ['timeline_url', null],
        'type' => ['type', \Acme\GitHub\Generated\Model\IssueType::class],
    ];

    /**
     * @param list<array<string, mixed>> $labels
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\IssueFieldValue> $issue_field_values
     */
    public function __construct(
        public NullableSimpleUser $assignee,
        public AuthorAssociation $author_association,
        public ?DateTimeImmutable $closed_at = null,
        public int $comments,
        public string $comments_url,
        public DateTimeImmutable $created_at,
        public string $events_url,
        public string $html_url,
        public int $id,
        public array $labels,
        public string $labels_url,
        public bool $locked,
        public NullableMilestone $milestone,
        public string $node_id,
        public int $number,
        public string $repository_url,
        public float $score,
        public string $state,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?string $active_lock_reason = null,
        public ?array $assignees = null,
        public ?string $body = null,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?bool $draft = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?IssueSearchResultItemPull_request $pull_request = null,
        public ?ReactionRollup $reactions = null,
        public ?Repository $repository = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?SearchResultTextMatches $text_matches = null,
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
            'assignee' => $this->assignee,
            'author_association' => $this->author_association,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'comments' => $this->comments,
            'comments_url' => $this->comments_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'events_url' => $this->events_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'labels' => $this->labels,
            'labels_url' => $this->labels_url,
            'locked' => $this->locked,
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'repository_url' => $this->repository_url,
            'score' => $this->score,
            'state' => $this->state,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'active_lock_reason' => $this->active_lock_reason,
            'assignees' => $this->assignees,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'draft' => $this->draft,
            'issue_dependencies_summary' => $this->issue_dependencies_summary,
            'issue_field_values' => $this->issue_field_values,
            'performed_via_github_app' => $this->performed_via_github_app,
            'pinned_comment' => $this->pinned_comment,
            'pull_request' => $this->pull_request,
            'reactions' => $this->reactions,
            'repository' => $this->repository,
            'state_reason' => $this->state_reason,
            'sub_issues_summary' => $this->sub_issues_summary,
            'text_matches' => $this->text_matches,
            'timeline_url' => $this->timeline_url,
            'type' => $this->type,
        ];
    }
}
