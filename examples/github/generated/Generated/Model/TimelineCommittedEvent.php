<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineCommittedEvent
{
    /**
     * @param list<array<string, mixed>> $parents
     */
    public function __construct(
        public TimelineCommittedEventAuthor $author,
        public TimelineCommittedEventCommitter $committer,
        public string $html_url,
        public string $message,
        public string $node_id,
        public array $parents,
        public string $sha,
        public TimelineCommittedEventTree $tree,
        public string $url,
        public TimelineCommittedEventVerification $verification,
        public ?string $event = null,
    ) {
    }
}
