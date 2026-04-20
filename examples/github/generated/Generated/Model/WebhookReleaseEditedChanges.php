<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookReleaseEditedChanges
{
    public function __construct(
        public ?WebhookReleaseEditedChangesBody $body = null,
        public ?WebhookReleaseEditedChangesMake_latest $make_latest = null,
        public ?WebhookReleaseEditedChangesName $name = null,
        public ?WebhookReleaseEditedChangesTag_name $tag_name = null,
    ) {
    }
}
