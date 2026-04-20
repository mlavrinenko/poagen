<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch1Pull_requestBaseRepoLicense
{
    public function __construct(
        public string $key,
        public string $name,
        public string $node_id,
        public string $spdx_id,
        public ?string $url = null,
    ) {
    }
}
