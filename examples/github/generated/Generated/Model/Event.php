<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Event
{
    public function __construct(
        public Actor $actor,
        public ?DateTimeImmutable $created_at = null,
        public string $id,
        public CreateEvent|DeleteEvent|DiscussionEvent|IssuesEvent|IssueCommentEvent|ForkEvent|GollumEvent|MemberEvent|PublicEvent|PushEvent|PullRequestEvent|PullRequestReviewCommentEvent|PullRequestReviewEvent|CommitCommentEvent|ReleaseEvent|WatchEvent $payload,
        public bool $public,
        public EventRepo $repo,
        public ?string $type = null,
        public ?Actor $org = null,
    ) {
    }
}
