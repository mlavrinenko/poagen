<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksPullRequest5Auto_merge
{
    public function __construct(
        public ?string $commit_message = null,
        public ?string $commit_title = null,
        public WebhooksPullRequest5Auto_mergeEnabled_by $enabled_by,
        public string $merge_method,
    ) {
    }
}
