<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAutoMergeDisabledPull_requestHead
{
    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestAutoMergeDisabledPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestAutoMergeDisabledPull_requestHeadUser $user,
    ) {
    }
}
