<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2ProjectEditedChanges
{
    public function __construct(
        public ?WebhookProjectsV2ProjectEditedChangesDescription $description = null,
        public ?WebhookProjectsV2ProjectEditedChangesPublic $public = null,
        public ?WebhookProjectsV2ProjectEditedChangesShort_description $short_description = null,
        public ?WebhookProjectsV2ProjectEditedChangesTitle $title = null,
    ) {
    }
}
