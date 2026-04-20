<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestLockedPull_requestHead
{
    public function __construct(
        public ?string $label = null,
        public string $ref,
        public WebhookPullRequestLockedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestLockedPull_requestHeadUser $user,
    ) {
    }
}
