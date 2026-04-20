<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestEditedChangesBase
{
    public function __construct(
        public WebhookPullRequestEditedChangesBaseRef $ref,
        public WebhookPullRequestEditedChangesBaseSha $sha,
    ) {
    }
}
