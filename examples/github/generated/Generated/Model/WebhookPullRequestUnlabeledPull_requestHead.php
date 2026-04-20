<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnlabeledPull_requestHead
{
    public function __construct(
        public ?string $label = null,
        public string $ref,
        public WebhookPullRequestUnlabeledPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestUnlabeledPull_requestHeadUser $user,
    ) {
    }
}
