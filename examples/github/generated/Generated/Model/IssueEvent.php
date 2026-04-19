<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;
use JsonSerializable;

final readonly class IssueEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor' => ['actor', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'commit_id' => ['commit_id', null],
        'commit_url' => ['commit_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'event' => ['event', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'url' => ['url', null],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'assigner' => ['assigner', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'author_association' => ['author_association', ['enum', \Acme\GitHub\Generated\Enum\AuthorAssociation::class]],
        'dismissed_review' => ['dismissed_review', \Acme\GitHub\Generated\Model\IssueEventDismissedReview::class],
        'issue' => ['issue', \Acme\GitHub\Generated\Model\NullableIssue::class],
        'label' => ['label', \Acme\GitHub\Generated\Model\IssueEventLabel::class],
        'lock_reason' => ['lock_reason', null],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\IssueEventMilestone::class],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'project_card' => ['project_card', \Acme\GitHub\Generated\Model\IssueEventProjectCard::class],
        'rename' => ['rename', \Acme\GitHub\Generated\Model\IssueEventRename::class],
        'requested_reviewer' => ['requested_reviewer', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'requested_team' => ['requested_team', \Acme\GitHub\Generated\Model\Team::class],
        'review_requester' => ['review_requester', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

    public function __construct(
        public NullableSimpleUser $actor,
        public ?string $commit_id = null,
        public ?string $commit_url = null,
        public DateTimeImmutable $created_at,
        public string $event,
        public int $id,
        public string $node_id,
        public string $url,
        public ?NullableSimpleUser $assignee = null,
        public ?NullableSimpleUser $assigner = null,
        public ?AuthorAssociation $author_association = null,
        public ?IssueEventDismissedReview $dismissed_review = null,
        public ?NullableIssue $issue = null,
        public ?IssueEventLabel $label = null,
        public ?string $lock_reason = null,
        public ?IssueEventMilestone $milestone = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?IssueEventProjectCard $project_card = null,
        public ?IssueEventRename $rename = null,
        public ?NullableSimpleUser $requested_reviewer = null,
        public ?Team $requested_team = null,
        public ?NullableSimpleUser $review_requester = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor' => $this->actor,
            'commit_id' => $this->commit_id,
            'commit_url' => $this->commit_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'event' => $this->event,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'url' => $this->url,
            'assignee' => $this->assignee,
            'assigner' => $this->assigner,
            'author_association' => $this->author_association,
            'dismissed_review' => $this->dismissed_review,
            'issue' => $this->issue,
            'label' => $this->label,
            'lock_reason' => $this->lock_reason,
            'milestone' => $this->milestone,
            'performed_via_github_app' => $this->performed_via_github_app,
            'project_card' => $this->project_card,
            'rename' => $this->rename,
            'requested_reviewer' => $this->requested_reviewer,
            'requested_team' => $this->requested_team,
            'review_requester' => $this->review_requester,
        ];
    }
}
