<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class IssueCommentEvent
{
    public function __construct(
        public string $action,
        public IssueComment $comment,
        public Issue $issue,
    ) {
    }
}
