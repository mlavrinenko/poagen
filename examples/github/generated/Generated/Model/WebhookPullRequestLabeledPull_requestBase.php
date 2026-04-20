<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestLabeledPull_requestBase
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestLabeledPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestLabeledPull_requestBaseUser $user,
    ) {
    }
}
