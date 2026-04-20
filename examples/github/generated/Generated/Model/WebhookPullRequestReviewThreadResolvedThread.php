<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadResolvedThread
{
    /**
     * @param list<array<string, mixed>> $comments
     */
    public function __construct(
        public array $comments,
        public string $node_id,
    ) {
    }
}
