<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestedBranch1Pull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewRequestedBranch1Pull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewRequestedBranch1Pull_requestBaseUser $user,
    ) {
    }
}
