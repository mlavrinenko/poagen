<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestEditedChanges
{
    public function __construct(
        public ?WebhookPullRequestEditedChangesBase $base = null,
        public ?WebhookPullRequestEditedChangesBody $body = null,
        public ?WebhookPullRequestEditedChangesTitle $title = null,
    ) {
    }
}
