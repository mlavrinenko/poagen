<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch2Pull_requestHead
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewRequestRemovedBranch2Pull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewRequestRemovedBranch2Pull_requestHeadUser $user,
    ) {
    }
}
