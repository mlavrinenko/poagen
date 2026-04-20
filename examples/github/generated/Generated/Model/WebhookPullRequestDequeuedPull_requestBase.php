<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestDequeuedPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestDequeuedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestDequeuedPull_requestBaseUser $user,
    ) {
    }
}
