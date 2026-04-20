<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesEditedChanges
{
    public function __construct(
        public ?WebhookIssuesEditedChangesBody $body = null,
        public ?WebhookIssuesEditedChangesTitle $title = null,
    ) {
    }
}
