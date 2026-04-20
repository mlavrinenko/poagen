<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectEditedChanges
{
    public function __construct(
        public ?WebhookProjectEditedChangesBody $body = null,
        public ?WebhookProjectEditedChangesName $name = null,
    ) {
    }
}
