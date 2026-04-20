<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksAnswer
{
    /**
     * @param ?mixed $parent_id
     */
    public function __construct(
        public string $author_association,
        public string $body,
        public int $child_comment_count,
        public DateTimeImmutable $created_at,
        public int $discussion_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public $parent_id = null,
        public string $repository_url,
        public DateTimeImmutable $updated_at,
        public WebhooksAnswerUser $user,
        public ?WebhooksAnswerReactions $reactions = null,
    ) {
    }
}
