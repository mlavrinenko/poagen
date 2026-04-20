<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnassignedPull_requestBase
{
    public function __construct(
        public ?string $label = null,
        public string $ref,
        public WebhookPullRequestUnassignedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestUnassignedPull_requestBaseUser $user,
    ) {
    }
}
