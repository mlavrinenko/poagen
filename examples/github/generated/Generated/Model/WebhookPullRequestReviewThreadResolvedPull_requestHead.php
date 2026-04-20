<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadResolvedPull_requestHead
{
    public function __construct(
        public ?string $label = null,
        public string $ref,
        public WebhookPullRequestReviewThreadResolvedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewThreadResolvedPull_requestHeadUser $user,
    ) {
    }
}
