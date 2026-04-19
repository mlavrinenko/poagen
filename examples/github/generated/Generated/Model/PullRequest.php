<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;
use JsonSerializable;

final readonly class PullRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\PullRequest_links::class],
        'additions' => ['additions', null],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'author_association' => ['author_association', ['enum', \Acme\GitHub\Generated\Enum\AuthorAssociation::class]],
        'auto_merge' => ['auto_merge', \Acme\GitHub\Generated\Model\AutoMerge::class],
        'base' => ['base', \Acme\GitHub\Generated\Model\PullRequestBase::class],
        'body' => ['body', null],
        'changed_files' => ['changed_files', null],
        'closed_at' => ['closed_at', ['datetime', null]],
        'comments' => ['comments', null],
        'comments_url' => ['comments_url', null],
        'commits' => ['commits', null],
        'commits_url' => ['commits_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'deletions' => ['deletions', null],
        'diff_url' => ['diff_url', null],
        'head' => ['head', \Acme\GitHub\Generated\Model\PullRequestHead::class],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'issue_url' => ['issue_url', null],
        'labels' => ['labels', ['list', null]],
        'locked' => ['locked', null],
        'maintainer_can_modify' => ['maintainer_can_modify', null],
        'merge_commit_sha' => ['merge_commit_sha', null],
        'mergeable' => ['mergeable', null],
        'mergeable_state' => ['mergeable_state', null],
        'merged' => ['merged', null],
        'merged_at' => ['merged_at', ['datetime', null]],
        'merged_by' => ['merged_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\NullableMilestone::class],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'patch_url' => ['patch_url', null],
        'review_comment_url' => ['review_comment_url', null],
        'review_comments' => ['review_comments', null],
        'review_comments_url' => ['review_comments_url', null],
        'state' => ['state', null],
        'statuses_url' => ['statuses_url', null],
        'title' => ['title', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'active_lock_reason' => ['active_lock_reason', null],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'draft' => ['draft', null],
        'rebaseable' => ['rebaseable', null],
        'requested_reviewers' => ['requested_reviewers', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'requested_teams' => ['requested_teams', ['list', \Acme\GitHub\Generated\Model\TeamSimple::class]],
    ];

    /**
     * @param list<array<string, mixed>> $labels
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $requested_reviewers
     * @param ?list<\Acme\GitHub\Generated\Model\TeamSimple> $requested_teams
     */
    public function __construct(
        public PullRequest_links $_links,
        public int $additions,
        public NullableSimpleUser $assignee,
        public AuthorAssociation $author_association,
        public AutoMerge $auto_merge,
        public PullRequestBase $base,
        public ?string $body = null,
        public int $changed_files,
        public ?DateTimeImmutable $closed_at = null,
        public int $comments,
        public string $comments_url,
        public int $commits,
        public string $commits_url,
        public DateTimeImmutable $created_at,
        public int $deletions,
        public string $diff_url,
        public PullRequestHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public bool $maintainer_can_modify,
        public ?string $merge_commit_sha = null,
        public ?bool $mergeable = null,
        public string $mergeable_state,
        public bool $merged,
        public ?DateTimeImmutable $merged_at = null,
        public NullableSimpleUser $merged_by,
        public NullableMilestone $milestone,
        public string $node_id,
        public int $number,
        public string $patch_url,
        public string $review_comment_url,
        public int $review_comments,
        public string $review_comments_url,
        public string $state,
        public string $statuses_url,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public SimpleUser $user,
        public ?string $active_lock_reason = null,
        public ?array $assignees = null,
        public ?bool $draft = null,
        public ?bool $rebaseable = null,
        public ?array $requested_reviewers = null,
        public ?array $requested_teams = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'additions' => $this->additions,
            'assignee' => $this->assignee,
            'author_association' => $this->author_association,
            'auto_merge' => $this->auto_merge,
            'base' => $this->base,
            'body' => $this->body,
            'changed_files' => $this->changed_files,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'comments' => $this->comments,
            'comments_url' => $this->comments_url,
            'commits' => $this->commits,
            'commits_url' => $this->commits_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'deletions' => $this->deletions,
            'diff_url' => $this->diff_url,
            'head' => $this->head,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'issue_url' => $this->issue_url,
            'labels' => $this->labels,
            'locked' => $this->locked,
            'maintainer_can_modify' => $this->maintainer_can_modify,
            'merge_commit_sha' => $this->merge_commit_sha,
            'mergeable' => $this->mergeable,
            'mergeable_state' => $this->mergeable_state,
            'merged' => $this->merged,
            'merged_at' => $this->merged_at?->format(\DateTimeInterface::RFC3339),
            'merged_by' => $this->merged_by,
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'patch_url' => $this->patch_url,
            'review_comment_url' => $this->review_comment_url,
            'review_comments' => $this->review_comments,
            'review_comments_url' => $this->review_comments_url,
            'state' => $this->state,
            'statuses_url' => $this->statuses_url,
            'title' => $this->title,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'active_lock_reason' => $this->active_lock_reason,
            'assignees' => $this->assignees,
            'draft' => $this->draft,
            'rebaseable' => $this->rebaseable,
            'requested_reviewers' => $this->requested_reviewers,
            'requested_teams' => $this->requested_teams,
        ];
    }
}
