<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewEditedPull_requestHead
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewEditedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewEditedPull_requestHeadUser $user,
    ) {
    }
}
