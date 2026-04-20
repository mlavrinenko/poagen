<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class NullableIssue
{
    /**
     * @param list<mixed> $labels
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\IssueFieldValue> $issue_field_values
     */
    public function __construct(
        public NullableSimpleUser $assignee,
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
        public string $state,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?string $active_lock_reason = null,
        public ?array $assignees = null,
        public ?AuthorAssociation $author_association = null,
        public ?string $body = null,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?NullableSimpleUser $closed_by = null,
        public ?bool $draft = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?string $parent_issue_url = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?NullableIssuePull_request $pull_request = null,
        public ?ReactionRollup $reactions = null,
        public ?Repository $repository = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?string $timeline_url = null,
        public ?IssueType $type = null,
    ) {
    }
}
