<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineCommitCommentedEvent implements TimelineIssueEvents
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\CommitComment> $comments
     */
    public function __construct(
        public ?array $comments = null,
        public ?string $commit_id = null,
        public ?string $event = null,
        public ?string $node_id = null,
    ) {
    }
}
