<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksReview
{
    public function __construct(
        public WebhooksReview_links $_links,
        public string $author_association,
        public ?string $body = null,
        public string $commit_id,
        public string $html_url,
        public int $id,
        public string $node_id,
        public string $pull_request_url,
        public string $state,
        public ?DateTimeImmutable $submitted_at = null,
        public WebhooksReviewUser $user,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
