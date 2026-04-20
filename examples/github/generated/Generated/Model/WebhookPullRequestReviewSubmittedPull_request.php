<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewSubmittedPull_request
{
    /**
     * @param list<array<string, mixed>> $assignees
     * @param list<array<string, mixed>> $labels
     * @param list<mixed> $requested_reviewers
     * @param list<array<string, mixed>> $requested_teams
     */
    public function __construct(
        public WebhookPullRequestReviewSubmittedPull_request_links $_links,
        public ?string $active_lock_reason = null,
        public WebhookPullRequestReviewSubmittedPull_requestAssignee $assignee,
        public array $assignees,
        public string $author_association,
        public WebhookPullRequestReviewSubmittedPull_requestAuto_merge $auto_merge,
        public WebhookPullRequestReviewSubmittedPull_requestBase $base,
        public ?string $body = null,
        public ?string $closed_at = null,
        public string $comments_url,
        public string $commits_url,
        public string $created_at,
        public string $diff_url,
        public bool $draft,
        public WebhookPullRequestReviewSubmittedPull_requestHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public ?string $merge_commit_sha = null,
        public ?string $merged_at = null,
        public WebhookPullRequestReviewSubmittedPull_requestMilestone $milestone,
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
        public WebhookPullRequestReviewSubmittedPull_requestUser $user,
    ) {
    }
}
