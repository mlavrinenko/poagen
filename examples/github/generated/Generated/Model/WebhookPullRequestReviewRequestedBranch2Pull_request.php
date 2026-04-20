<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookPullRequestReviewRequestedBranch2Pull_request
{
    /**
     * @param list<array<string, mixed>> $assignees
     * @param list<array<string, mixed>> $labels
     * @param list<mixed> $requested_reviewers
     * @param list<array<string, mixed>> $requested_teams
     */
    public function __construct(
        public WebhookPullRequestReviewRequestedBranch2Pull_request_links $_links,
        public ?string $active_lock_reason = null,
        public WebhookPullRequestReviewRequestedBranch2Pull_requestAssignee $assignee,
        public array $assignees,
        public string $author_association,
        public WebhookPullRequestReviewRequestedBranch2Pull_requestAuto_merge $auto_merge,
        public WebhookPullRequestReviewRequestedBranch2Pull_requestBase $base,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public string $comments_url,
        public string $commits_url,
        public DateTimeImmutable $created_at,
        public string $diff_url,
        public bool $draft,
        public WebhookPullRequestReviewRequestedBranch2Pull_requestHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public ?string $merge_commit_sha = null,
        public ?DateTimeImmutable $merged_at = null,
        public WebhookPullRequestReviewRequestedBranch2Pull_requestMilestone $milestone,
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
        public WebhookPullRequestReviewRequestedBranch2Pull_requestUser $user,
        public ?int $additions = null,
        public ?int $changed_files = null,
        public ?int $comments = null,
        public ?int $commits = null,
        public ?int $deletions = null,
        public ?bool $maintainer_can_modify = null,
        public ?bool $mergeable = null,
        public ?string $mergeable_state = null,
        public ?bool $merged = null,
        public ?WebhookPullRequestReviewRequestedBranch2Pull_requestMerged_by $merged_by = null,
        public ?bool $rebaseable = null,
        public ?int $review_comments = null,
    ) {
    }
}
