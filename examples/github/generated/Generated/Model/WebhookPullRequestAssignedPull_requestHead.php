<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAssignedPull_requestHead
{
    public function __construct(
        public ?string $label = null,
        public string $ref,
        public WebhookPullRequestAssignedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestAssignedPull_requestHeadUser $user,
    ) {
    }
}
