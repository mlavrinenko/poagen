<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineLineCommentedEvent implements TimelineIssueEvents
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestReviewComment> $comments
     */
    public function __construct(
        public ?array $comments = null,
        public ?string $event = null,
        public ?string $node_id = null,
    ) {
    }
}
