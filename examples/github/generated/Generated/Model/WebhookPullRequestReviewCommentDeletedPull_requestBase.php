<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentDeletedPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewCommentDeletedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewCommentDeletedPull_requestBaseUser $user,
    ) {
    }
}
