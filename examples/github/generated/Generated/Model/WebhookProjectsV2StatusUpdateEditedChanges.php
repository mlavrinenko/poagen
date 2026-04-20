<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2StatusUpdateEditedChanges
{
    public function __construct(
        public ?WebhookProjectsV2StatusUpdateEditedChangesBody $body = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesStart_date $start_date = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesStatus $status = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesTarget_date $target_date = null,
    ) {
    }
}
