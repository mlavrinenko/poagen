<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnlabeledPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestUnlabeledPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestUnlabeledPull_requestBaseUser $user,
    ) {
    }
}
