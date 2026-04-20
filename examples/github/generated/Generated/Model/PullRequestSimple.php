<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class PullRequestSimple
{
    /**
     * @param list<array<string, mixed>> $labels
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $requested_reviewers
     * @param ?list<\Acme\GitHub\Generated\Model\Team> $requested_teams
     */
    public function __construct(
        public PullRequestSimple_links $_links,
        public NullableSimpleUser $assignee,
        public AuthorAssociation $author_association,
        public AutoMerge $auto_merge,
        public PullRequestSimpleBase $base,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public string $comments_url,
        public string $commits_url,
        public DateTimeImmutable $created_at,
        public string $diff_url,
        public PullRequestSimpleHead $head,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public array $labels,
        public bool $locked,
        public ?string $merge_commit_sha = null,
        public ?DateTimeImmutable $merged_at = null,
        public NullableMilestone $milestone,
        public string $node_id,
        public int $number,
        public string $patch_url,
        public string $review_comment_url,
        public string $review_comments_url,
        public string $state,
        public string $statuses_url,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?string $active_lock_reason = null,
        public ?array $assignees = null,
        public ?bool $draft = null,
        public ?array $requested_reviewers = null,
        public ?array $requested_teams = null,
    ) {
    }
}
