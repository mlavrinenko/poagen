<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewEditedPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewEditedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewEditedPull_requestBaseUser $user,
    ) {
    }
}
