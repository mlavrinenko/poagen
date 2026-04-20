<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksIssueComment
{
    public function __construct(
        public string $author_association,
        public string $body,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public string $node_id,
        public Integration $performed_via_github_app,
        public WebhooksIssueCommentReactions $reactions,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhooksIssueCommentUser $user,
        public ?NullablePinnedIssueComment $pin = null,
    ) {
    }
}
