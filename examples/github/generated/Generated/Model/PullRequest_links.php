<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequest_links
{
    public function __construct(
        public Link $comments,
        public Link $commits,
        public Link $html,
        public Link $issue,
        public Link $review_comment,
        public Link $review_comments,
        public Link $self,
        public Link $statuses,
    ) {
    }
}
