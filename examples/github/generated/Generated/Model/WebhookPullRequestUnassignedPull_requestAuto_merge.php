<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnassignedPull_requestAuto_merge
{
    public function __construct(
        public ?string $commit_message = null,
        public ?string $commit_title = null,
        public WebhookPullRequestUnassignedPull_requestAuto_mergeEnabled_by $enabled_by,
        public string $merge_method,
    ) {
    }
}
