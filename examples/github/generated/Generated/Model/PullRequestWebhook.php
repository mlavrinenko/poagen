<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class PullRequestWebhook
{
    /**
     * @param list<array<string, mixed>> $labels
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $requested_reviewers
     * @param ?list<\Acme\GitHub\Generated\Model\TeamSimple> $requested_teams
     */
    public function __construct(
        public PullRequestWebhook_links $_links,
        public int $additions,
        public NullableSimpleUser $assignee,
        public AuthorAssociation $author_association,
        public AutoMerge $auto_merge,
        public PullRequestWebhookBase $base,
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
        public PullRequestWebhookHead $head,
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
        public ?bool $allow_auto_merge = null,
        public ?bool $allow_update_branch = null,
        public ?array $assignees = null,
        public ?bool $delete_branch_on_merge = null,
        public ?bool $draft = null,
        public ?string $merge_commit_message = null,
        public ?string $merge_commit_title = null,
        public ?bool $rebaseable = null,
        public ?array $requested_reviewers = null,
        public ?array $requested_teams = null,
        public ?string $squash_merge_commit_message = null,
        public ?string $squash_merge_commit_title = null,
        public ?bool $use_squash_pr_title_as_default = null,
    ) {
    }
}
