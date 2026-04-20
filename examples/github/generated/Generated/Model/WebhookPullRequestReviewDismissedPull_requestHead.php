<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewDismissedPull_requestHead
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewDismissedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewDismissedPull_requestHeadUser $user,
    ) {
    }
}
