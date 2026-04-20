<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDiscussionEditedChanges
{
    public function __construct(
        public ?WebhookDiscussionEditedChangesBody $body = null,
        public ?WebhookDiscussionEditedChangesTitle $title = null,
    ) {
    }
}
