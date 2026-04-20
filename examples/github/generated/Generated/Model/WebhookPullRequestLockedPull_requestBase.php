<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestLockedPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestLockedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestLockedPull_requestBaseUser $user,
    ) {
    }
}
