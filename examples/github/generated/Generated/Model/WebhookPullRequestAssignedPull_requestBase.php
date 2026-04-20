<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAssignedPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestAssignedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestAssignedPull_requestBaseUser $user,
    ) {
    }
}
