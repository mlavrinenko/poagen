<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookIssuesLabeledIssue
{
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
        public WebhookIssuesLabeledIssueMilestone $milestone,
        public string $node_id,
        public int $number,
        public WebhookIssuesLabeledIssueReactions $reactions,
        public string $repository_url,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhookIssuesLabeledIssueUser $user,
        public ?WebhookIssuesLabeledIssueAssignee $assignee = null,
        public ?bool $draft = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?array $labels = null,
        public ?bool $locked = null,
        public ?WebhookIssuesLabeledIssuePerformed_via_github_app $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?WebhookIssuesLabeledIssuePull_request $pull_request = null,
        public ?string $state = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?string $timeline_url = null,
        public ?IssueType $type = null,
    ) {
    }
}
