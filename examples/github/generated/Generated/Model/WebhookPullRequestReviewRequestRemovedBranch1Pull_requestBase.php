<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch1Pull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_requestBaseUser $user,
    ) {
    }
}
