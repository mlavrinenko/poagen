<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookIssuesOpenedChangesOld_issue
{
    /**
     * @param ?list<array<string, mixed>> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\IssueFieldValue> $issue_field_values
     * @param ?list<array<string, mixed>> $labels
     */
    public function __construct(
        public int $id,
        public int $number,
        public ?string $active_lock_reason = null,
        public ?WebhookIssuesOpenedChangesOld_issueAssignee $assignee = null,
        public ?array $assignees = null,
        public ?string $author_association = null,
        public ?string $body = null,
        public ?DateTimeImmutable $closed_at = null,
        public ?int $comments = null,
        public ?string $comments_url = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $draft = null,
        public ?string $events_url = null,
        public ?string $html_url = null,
        public ?IssueDependenciesSummary $issue_dependencies_summary = null,
        public ?array $issue_field_values = null,
        public ?array $labels = null,
        public ?string $labels_url = null,
        public ?bool $locked = null,
        public ?WebhookIssuesOpenedChangesOld_issueMilestone $milestone = null,
        public ?string $node_id = null,
        public ?WebhookIssuesOpenedChangesOld_issuePerformed_via_github_app $performed_via_github_app = null,
        public ?NullableIssueComment $pinned_comment = null,
        public ?WebhookIssuesOpenedChangesOld_issuePull_request $pull_request = null,
        public ?WebhookIssuesOpenedChangesOld_issueReactions $reactions = null,
        public ?string $repository_url = null,
        public ?string $state = null,
        public ?string $state_reason = null,
        public ?SubIssuesSummary $sub_issues_summary = null,
        public ?string $timeline_url = null,
        public ?string $title = null,
        public ?IssueType $type = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?WebhookIssuesOpenedChangesOld_issueUser $user = null,
    ) {
    }
}
