<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class TimelineCommentEvent
{
    public function __construct(
        public SimpleUser $actor,
        public AuthorAssociation $author_association,
        public DateTimeImmutable $created_at,
        public string $event,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public string $url,
        public SimpleUser $user,
        public ?string $body = null,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?NullablePinnedIssueComment $pin = null,
        public ?ReactionRollup $reactions = null,
    ) {
    }
}
