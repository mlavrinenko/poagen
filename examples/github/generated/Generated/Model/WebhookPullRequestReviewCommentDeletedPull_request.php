<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestReviewCommentDeletedPull_request implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => [
            '_links',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_request_links::class,
        ],
        'active_lock_reason' => ['active_lock_reason', null],
        'assignee' => [
            'assignee',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestAssignee::class,
        ],
        'assignees' => ['assignees', ['list', null]],
        'author_association' => ['author_association', null],
        'base' => ['base', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestBase::class],
        'body' => ['body', null],
        'closed_at' => ['closed_at', null],
        'comments_url' => ['comments_url', null],
        'commits_url' => ['commits_url', null],
        'created_at' => ['created_at', null],
        'diff_url' => ['diff_url', null],
        'head' => ['head', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestHead::class],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'issue_url' => ['issue_url', null],
        'labels' => ['labels', ['list', null]],
        'locked' => ['locked', null],
        'merge_commit_sha' => ['merge_commit_sha', null],
        'merged_at' => ['merged_at', null],
        'milestone' => [
            'milestone',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestMilestone::class,
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
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestUser::class],
        'auto_merge' => [
            'auto_merge',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewCommentDeletedPull_requestAuto_merge::class,
        ],
        'draft' => ['draft', null],
    ];

    /**
     * @param list<array<string, mixed>> $assignees
     * @param list<array<string, mixed>> $labels
     * @param list<mixed> $requested_reviewers
     * @param list<array<string, mixed>> $requested_teams
     */
    public function __construct(
        public WebhookPullRequestReviewCommentDeletedPull_request_links $_links,
        public ?string $active_lock_reason = null,
        public WebhookPullRequestReviewCommentDeletedPull_requestAssignee $assignee,
        public array $assignees,
        public string $author_association,
        public WebhookPullRequestReviewCommentDeletedPull_requestBase $base,
        public ?string $body = null,
        public ?string $closed_at = null,
        public string $comments_url,
        public string $commits_url,
        public string $created_at,
        public string $diff_url,
        public WebhookPullRequestReviewCommentDeletedPull_requestHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public ?string $merge_commit_sha = null,
        public ?string $merged_at = null,
        public WebhookPullRequestReviewCommentDeletedPull_requestMilestone $milestone,
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
        public string $updated_at,
        public string $url,
        public WebhookPullRequestReviewCommentDeletedPull_requestUser $user,
        public ?WebhookPullRequestReviewCommentDeletedPull_requestAuto_merge $auto_merge = null,
        public ?bool $draft = null,
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
            'base' => $this->base,
            'body' => $this->body,
            'closed_at' => $this->closed_at,
            'comments_url' => $this->comments_url,
            'commits_url' => $this->commits_url,
            'created_at' => $this->created_at,
            'diff_url' => $this->diff_url,
            'head' => $this->head,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'issue_url' => $this->issue_url,
            'labels' => $this->labels,
            'locked' => $this->locked,
            'merge_commit_sha' => $this->merge_commit_sha,
            'merged_at' => $this->merged_at,
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
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'user' => $this->user,
            'auto_merge' => $this->auto_merge,
            'draft' => $this->draft,
        ];
    }
}
