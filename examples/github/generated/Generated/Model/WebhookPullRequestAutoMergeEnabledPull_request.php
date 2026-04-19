<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookPullRequestAutoMergeEnabledPull_request implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_request_links::class],
        'active_lock_reason' => ['active_lock_reason', null],
        'assignee' => [
            'assignee',
            \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestAssignee::class,
        ],
        'assignees' => ['assignees', ['list', null]],
        'author_association' => ['author_association', null],
        'auto_merge' => [
            'auto_merge',
            \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestAuto_merge::class,
        ],
        'base' => ['base', \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestBase::class],
        'body' => ['body', null],
        'closed_at' => ['closed_at', ['datetime', null]],
        'comments_url' => ['comments_url', null],
        'commits_url' => ['commits_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'diff_url' => ['diff_url', null],
        'draft' => ['draft', null],
        'head' => ['head', \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestHead::class],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'issue_url' => ['issue_url', null],
        'labels' => ['labels', ['list', null]],
        'locked' => ['locked', null],
        'merge_commit_sha' => ['merge_commit_sha', null],
        'merged_at' => ['merged_at', ['datetime', null]],
        'milestone' => [
            'milestone',
            \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestMilestone::class,
        ],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'patch_url' => ['patch_url', null],
        'requested_reviewers' => ['requested_reviewers', ['list', null]],
        'requested_teams' => ['requested_teams', ['list', null]],
        'review_comment_url' => ['review_comment_url', null],
        'review_comments_url' => ['review_comments_url', null],
        'state' => ['state', null],
        'statuses_url' => ['statuses_url', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestUser::class],
        'additions' => ['additions', null],
        'changed_files' => ['changed_files', null],
        'comments' => ['comments', null],
        'commits' => ['commits', null],
        'deletions' => ['deletions', null],
        'maintainer_can_modify' => ['maintainer_can_modify', null],
        'mergeable' => ['mergeable', null],
        'mergeable_state' => ['mergeable_state', null],
        'merged' => ['merged', null],
        'merged_by' => [
            'merged_by',
            \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestMerged_by::class,
        ],
        'rebaseable' => ['rebaseable', null],
        'review_comments' => ['review_comments', null],
    ];

    /**
     * @param list<array<string, mixed>> $assignees
     * @param list<array<string, mixed>> $labels
     * @param list<mixed> $requested_reviewers
     * @param list<array<string, mixed>> $requested_teams
     */
    public function __construct(
        public WebhookPullRequestAutoMergeEnabledPull_request_links $_links,
        public ?string $active_lock_reason = null,
        public WebhookPullRequestAutoMergeEnabledPull_requestAssignee $assignee,
        public array $assignees,
        public string $author_association,
        public WebhookPullRequestAutoMergeEnabledPull_requestAuto_merge $auto_merge,
        public WebhookPullRequestAutoMergeEnabledPull_requestBase $base,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public string $comments_url,
        public string $commits_url,
        public DateTimeImmutable $created_at,
        public string $diff_url,
        public bool $draft,
        public WebhookPullRequestAutoMergeEnabledPull_requestHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public ?string $merge_commit_sha = null,
        public ?DateTimeImmutable $merged_at = null,
        public WebhookPullRequestAutoMergeEnabledPull_requestMilestone $milestone,
        public string $node_id,
        public int $number,
        public string $patch_url,
        public array $requested_reviewers,
        public array $requested_teams,
        public string $review_comment_url,
        public string $review_comments_url,
        public string $state,
        public string $statuses_url,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhookPullRequestAutoMergeEnabledPull_requestUser $user,
        public ?int $additions = null,
        public ?int $changed_files = null,
        public ?int $comments = null,
        public ?int $commits = null,
        public ?int $deletions = null,
        public ?bool $maintainer_can_modify = null,
        public ?bool $mergeable = null,
        public ?string $mergeable_state = null,
        public ?bool $merged = null,
        public ?WebhookPullRequestAutoMergeEnabledPull_requestMerged_by $merged_by = null,
        public ?bool $rebaseable = null,
        public ?int $review_comments = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'active_lock_reason' => $this->active_lock_reason,
            'assignee' => $this->assignee,
            'assignees' => $this->assignees,
            'author_association' => $this->author_association,
            'auto_merge' => $this->auto_merge,
            'base' => $this->base,
            'body' => $this->body,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'comments_url' => $this->comments_url,
            'commits_url' => $this->commits_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'diff_url' => $this->diff_url,
            'draft' => $this->draft,
            'head' => $this->head,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'issue_url' => $this->issue_url,
            'labels' => $this->labels,
            'locked' => $this->locked,
            'merge_commit_sha' => $this->merge_commit_sha,
            'merged_at' => $this->merged_at?->format(\DateTimeInterface::RFC3339),
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'patch_url' => $this->patch_url,
            'requested_reviewers' => $this->requested_reviewers,
            'requested_teams' => $this->requested_teams,
            'review_comment_url' => $this->review_comment_url,
            'review_comments_url' => $this->review_comments_url,
            'state' => $this->state,
            'statuses_url' => $this->statuses_url,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'additions' => $this->additions,
            'changed_files' => $this->changed_files,
            'comments' => $this->comments,
            'commits' => $this->commits,
            'deletions' => $this->deletions,
            'maintainer_can_modify' => $this->maintainer_can_modify,
            'mergeable' => $this->mergeable,
            'mergeable_state' => $this->mergeable_state,
            'merged' => $this->merged,
            'merged_by' => $this->merged_by,
            'rebaseable' => $this->rebaseable,
            'review_comments' => $this->review_comments,
        ];
    }
}
