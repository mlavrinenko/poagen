<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadUnresolvedPull_requestHead
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewThreadUnresolvedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewThreadUnresolvedPull_requestHeadUser $user,
    ) {
    }
}
